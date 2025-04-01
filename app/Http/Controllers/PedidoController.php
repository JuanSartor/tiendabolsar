<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Envio;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class PedidoController extends Controller {

    public function index(Request $request) {
        $search = $request->input('search'); // Obtener el término de búsqueda
        $pedidos = Pedido::where('id', 'like', "%{$search}%")->paginate(15);

        return view('pedido.gestion', compact('pedidos', 'search'));
    }

    public function mispedidos(Request $request) {
        $search = $request->input('search');

        $pedidos = Pedido::where('id', 'like', "%{$search}%")
                ->where('user_id', auth()->id())
                ->paginate(15);
        return view('pedido.gestion', compact('pedidos', 'search'));
    }

    public function realizar() {

        return view('pedido.hacer');
    }

    public function detalle($id) {
        $pedido = Pedido::findOrFail($id);
        $envio = Envio::where('pedido_id', $pedido->id)->first();

// obtengo el pago para saber que metodo selecciono
        $pago = Pago::where('id_pedido', $pedido->id)->first();

        return view('pedido.detalle', compact('pedido', 'envio', 'pago'));
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function updateEstado(Request $request) {
        $pedido = Pedido::findOrFail($request->pedido_id);
        $pedido->estado = $request->estado;
        $pedido->save();

        return redirect()->route('pedido.detalle', $pedido->id)
                        ->with('success', 'El estado del pedido ha sido actualizado.');
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function guardar(Request $request) {

// Verifica si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('home')->with('error', 'Debes iniciar sesión para hacer un pedido.');
        }

        $userId = Auth::id();

// Validación de datos
        $validatedData = $request->validate([
            'provincia' => 'required|string|max:255',
            'localidad' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
        ]);

        $carrito = Session::get('carrito');

        if (!$carrito || count($carrito) === 0) {
            return redirect()->route('carrito.index')->with('error', 'El carrito está vacío.');
        }

        $coste = array_reduce($carrito, fn($sum, $item) => $sum + ($item['precio'] * $item['unidades']), 0);

// Guardar datos en la base de datos
        $pedido = Pedido::create([
            'user_id' => $userId,
            'provincia' => $validatedData['provincia'],
            'localidad' => $validatedData['localidad'],
            'direccion' => $validatedData['direccion'],
            'coste' => $coste,
            'estado' => 'confirm',
        ]);

// Guardar línea de pedidos
        foreach ($carrito as $producto) {
            $pedido->productos()->attach($producto['id_producto'], ['unidades' => $producto['unidades']]);
        }

// Confirmación de pedido
        Session::put('pedido', 'complete');

//vacio el carrito
        Session::forget('carrito');
        return redirect()->route('pedido.confirmar')->with('success', 'Pedido confirmado con éxito.');
    }

    /**
     * 
     */
    public function confirmado() {

// Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('home')->with('error', 'Debes iniciar sesión.');
        }

// Obtener el último pedido del usuario autenticado
        $userId = Auth::id();
        $pedido = Pedido::where('user_id', $userId)->latest()->first();

        if (!$pedido) {
            return redirect()->route('home')->with('error', 'No se encontró ningún pedido.');
        }

// Obtener productos asociados al pedido
        $productos = $pedido->productos;

// calcular y mostrar opciones de envio, si selecciono el envio por mercadopago(envioDomicilio)
        if ($pedido->envio->tipo_envio == 'envioDomicilio') {
            $opciones_envio = $this->calcularEnvio($pedido, $pedido->envio);
        } else {
            $opciones_envio = '';
        }



        return view('pedido.confirmado', compact('pedido', 'productos', 'opciones_envio'));
    }

    /**
     * 
     * @param Pedido $pedido
     * @param Envio $envio
     * @return type
     */
    public function calcularEnvio(Pedido $pedido, Envio $envio) {
        $access_token = env('MERCADOPAGO_ACCESS_TOKEN');
        $user_id = env('MERCADOLIBRE_USER_ID');

        $zip_code = $envio["codigo_postal"];
        $origin_zip = env('CODIGO_POSTAL_ORIGEN_MERCADOENVIO'); // Código postal de tu tienda

        $shipping_details = []; // Lista de envíos individuales

        foreach ($pedido->productos as $package) {
            // Recorrer cada unidad del producto como un envío separado
            for ($i = 0; $i < $package->pivot->unidades; $i++) {

                $dimensions = "{$package['largo']}x{$package['ancho']}x{$package['alto']},{$package['peso']}";

                $response = Http::get("https://api.mercadolibre.com/users/{$user_id}/shipping_options", [
                    "access_token" => $access_token,
                    "dimensions" => $dimensions,
                    "zip_code" => $zip_code,
                    "origin_zip" => $origin_zip,
                    "item_price" => $package['precio']
                ]);

                $data = $response->json();

                if (isset($data['options']) && !empty($data['options'])) {
                    // Guardamos cada envío como un array independiente
                    $shipping_details[] = [
                        "producto" => $package['nombre'],
                        "cantidad" => 1,
                        "dimensions" => $dimensions,
                        "opciones_envio" => $data['options']
                    ];
                }
            }
        }

        $response = response()->json([
            "total_envios" => count($shipping_details),
            "detalle_envios" => $shipping_details
        ]);
        $responseData = $response->getData(true);
        // Extraer todas las opciones de envío por producto
        $shippingOptionsPerProduct = [];
        foreach ($responseData['detalle_envios'] as $envio) {
            foreach ($envio['opciones_envio'] as $opcion) {
                $shippingOptionsPerProduct[$opcion['shipping_method_id']]['name'] = $opcion['name'];
                $shippingOptionsPerProduct[$opcion['shipping_method_id']]['costs'][] = $opcion['cost'];
            }
        }


// Filtrar opciones que están en todos los productos y calcular el costo total
        $totalProducts = count($responseData['detalle_envios']);
        $commonShippingOptions = [];

        $i = 1;
        foreach ($shippingOptionsPerProduct as $methodId => $option) {
            if (count($option['costs']) === $totalProducts) {
                $commonShippingOptions[$methodId] = [
                    'id' => $methodId,
                    'cantidad_envios' => $totalProducts,
                    'name' => $option['name'],
                    'total_cost' => array_sum($option['costs'])
                ];
            }
            if ($i == 1) {

                // seteo el id de envio seleccionado que identifica para mercadopago
                Session::put('idenvio', $methodId);

                $pedido->costo_envio = array_sum($option['costs']);
                $pedido->save();
                $i++;
            }
        }

        return $commonShippingOptions;
    }
}
