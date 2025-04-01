<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;
use MercadoPago\Payment;
use MercadoPago\Shipments;
use App\Models\Pago;
use App\Models\Pedido;
use App\Models\LineaPedido;
use App\Models\Producto;
use Log;
use Illuminate\Support\Facades\Mail;
use App\Models\ConfirmacionPagoCorreo;
use Illuminate\Support\Facades\Session;

class PagoController extends Controller {

    public function pagoPorTransferencia($idPedido) {
        // ahora registro el tipo de pago, seteo el estado del pedido, el tipo de pago y el pago
        // por ultimo lo redirijo a la pagina de detalle pedido

        $pagoTransferencia = new Pago();
        $pagoTransferencia->id_pedido = $idPedido;
        $pagoTransferencia->tipo_pago = "transferencia";
        $pagoTransferencia->save();

        $pedido = Pedido::findOrFail($idPedido);
        $pedido->estado = "esperandoConfirmacion";
        $pedido->save();

        return redirect()->route('pedido.detalle', $pedido->id)
                        ->with('success', 'El estado del pedido ha sido actualizado.');
    }

    public function pagoMercadoPago($id) {
        // Autenticación con las credenciales
        SDK::setAccessToken(config('services.mercadopago.access_token'));

        $pedido = Pedido::findOrFail($id);
        // Obtener productos asociados al pedido
        $productos = $pedido->productos;

        // Crear una preferencia de pago
        $preference = new Preference();

        $items = [];

        // Obtener el método de envío seleccionado desde la sesión
        $shipping_method_id = Session::get('idenvio');

        foreach ($productos as $producto) {
            $item = new Item();
            $item->title = $producto['nombre'];
            $item->quantity = $producto['pivot']['unidades'];
            $item->currency_id = 'ARS';
            $item->unit_price = $producto['precio'];
            $items[] = $item;

            ////////////////////////////////////////////////////////////
            // Configurar el envío para cada unidad
            ///////////////////////////////////////////////////////////
            if ($pedido->envio->tipo_envio != 'coordinarEnvio') {
                $dimensions = "{$producto['largo']}x{$producto['ancho']}x{$producto['alto']},{$producto['peso']}";
                $shipments = new Shipments();
                $shipments->mode = 'me2';  // Mercado Envíos
                $shipments->default_shipping_method = $shipping_method_id;
                $shipments->dimensions = $dimensions;
                $shipments->zip_code = env('CODIGO_POSTAL_ORIGEN_MERCADOENVIO');

                // Agregar el envío a la preferencia
                $preference->shipments = $shipments;
            }
        }
        // guardo como referencia externa el id del pedido entonces despues lo recibo
        // en webhook y se a quien pertenece el pago recibido
        $preference->external_reference = $id;
        //agrego que la preferencia caduque a los 3 dias
        $preference->expiration_date_to = date('c', strtotime('+3 days'));

        $preference->items = $items;

        try {
            // Guardar y obtener la URL de pago
            $preference->save();

            // guardo el init_point en la tabla pago

            $pagoMercadopago = new Pago();
            $pagoMercadopago->id_pedido = $id;
            $pagoMercadopago->tipo_pago = "mercadopago";
            $pagoMercadopago->init_point_mercadopago = $preference->init_point;
            $pagoMercadopago->pref_id = $preference->id;
            $pagoMercadopago->save();

            $pedido->estado = "esperandoConfirmacion";
            $pedido->save();

            session()->forget('idenvio');

            return redirect()->route('pedido.detalle', $id)
                            ->with('success', 'El estado del pedido ha sido actualizado.');
        } catch (Exception $e) {
            // Registrar el error en el log para análisis
            \Log::error('Error al guardar la preferencia de pago: ' . $e->getMessage());

            // Retornar con un mensaje de error al usuario
            return redirect()->route('pedido.detalle', $id)
                            ->with('error', 'Hubo un problema al generar el pago. Por favor, intenta nuevamente.');
        }
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function handle(Request $request) {
        ini_set('max_execution_time', 120);

        $paymentId = $request->input('data.id');

// Autenticación de MercadoPago (cargar el SDK de MercadoPago)
        SDK::setAccessToken(config('services.mercadopago.access_token'));

        // Obtener detalles del pago a través de la API de MercadoPago
        $payment = Payment::find_by_id($paymentId);
        $pedido = Pedido::find($payment->external_reference);

        if ($pedido != 'pagado') {
            // Verificar que la respuesta fue correcta
            if ($payment->status == 'approved') {

                // inserto el paymentid en la tabla pagos
                $ultimoPago = Pago::where('id_pedido', $payment->external_reference)
                        ->latest()
                        ->first();
                $ultimoPago->payment_id = $paymentId;
                $ultimoPago->save();

                // cambio el estado del pedido
                $pedido->estado = 'pagado';
                $pedido->save();

                // descuento el stock disponible de productos en la base de datos


                $productos_blade = collect();

                $lineasPedidos = LineaPedido::where('pedido_id', $payment->external_reference)->get();
                foreach ($lineasPedidos as $linea) {

                    $producto = Producto::find($linea["producto_id"]);
                    $producto->stock = $producto->stock - $linea['unidades'];
                    $producto->save();

                    $producto_blade = clone $producto;

                    $producto_blade->cantidad_vendido = $linea['unidades'];
                    $productos_blade->push($producto_blade);
                }
                // envio un mail de que recibi el pago de una compra



                $datos = [
                    'idpedido' => $payment->external_reference,
                    'tipo_pago' => $ultimoPago["tipo_pago"],
                    'productos' => $productos_blade,
                    'costo_productos' => $pedido["costo_productos"],
                    'costo_envio' => $pedido["costo_envio"]
                ];
// mail que va a recibir las notificaciones
                Mail::to('juansartor92@gmail.com')->send(new ConfirmacionPagoCorreo($datos));

                //   Log::info('Webhook recibido: ', json_decode(json_encode($request["data"]), true));
                // Log::info('Webhook recibido: ' . $payment->external_reference);
            } else {
                // Si el pago no es exitoso, manejar el error
                // echo "Pago no aprobado. Estado: " . $payment->status;
                // $preferenceId = $payment->preference_id; // Esto es el pref_id de la preferencia que se asocia al pago

                Log::info('Webhook recibido no aceptado: ', json_decode(json_encode($request), true));
                Log::info('Webhook recibido: ' . $payment->external_reference);
            }
        }


        // return response()->json(['message' => 'Webhook recibido'], 200);
    }
}
