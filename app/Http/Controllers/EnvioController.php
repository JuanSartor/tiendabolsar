<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Pedido;
use App\Models\Envio;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;
use MercadoPago\Shipments;

class EnvioController extends Controller {

    public function guardar(Request $request) {

// Verifica si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('home')->with('error', 'Debes iniciar sesión para hacer un pedido.');
        }

        $userId = Auth::id();

// Validación de datos

        if ($request["tipo_envio"] != 'coordinarEnvio') {
            $validatedData = $request->validate([
                'provincia' => 'string|max:255',
                'localidad' => 'string|max:255',
                'direccion' => 'string|max:255',
                'nombre_receptor' => 'string|max:255',
                'dni_receptor' => 'string|max:255',
                'telefono' => 'string|max:255',
                'codigo_postal' => 'max:255',
            ]);
        } else {
            $validatedData = $request->validate([
                'nombre_receptor' => 'string|max:255',
                'dni_receptor' => 'string|max:255',
                'telefono' => 'string|max:255',
            ]);
        }



        $carrito = Session::get('carrito');

        //chequeo que el carrito no este vacio
        if (!$carrito || count($carrito) === 0) {
            return redirect()->route('carrito.index')->with('error', 'El carrito está vacío.');
        }

        // chequeo que todos los productos tengan stock disponible   

        foreach ($carrito as $item) {
            if ($item['unidades'] > $item['producto']['stock']) {
                return redirect()->route('carrito.index')
                                ->with('failed', 'No contamos con el stock suficiene de ' . $item['producto']['nombre'] . ' solo quedan disponible '
                                        . $item['producto']['stock']);
            }
        }


        ///
        // calculo el costo
        $coste = array_reduce($carrito, fn($sum, $item) => $sum + ($item['precio'] * $item['unidades']), 0);

// Guardar datos en la base de datos
        $pedido = Pedido::create([
            'user_id' => $userId,
            'costo_productos' => $coste,
            'costo_envio' => '0',
            'estado' => 'confirm',
        ]);

        if ($request["tipo_envio"] != 'coordinarEnvio') {
            // Guardar datos del envio en la base de datos
            Envio::create([
                'user_id' => $userId,
                'pedido_id' => $pedido->id,
                'provincia' => strtoupper($validatedData['provincia']),
                'localidad' => strtoupper($validatedData['localidad']),
                'direccion' => strtoupper($validatedData['direccion']),
                'nombre_receptor' => $validatedData['nombre_receptor'],
                'dni_receptor' => $validatedData['dni_receptor'],
                'telefono' => $validatedData['telefono'],
                'tipo_envio' => $request['tipo_envio'],
                'codigo_postal' => $request['codigo_postal'],
            ]);
        } else {
            Envio::create([
                'user_id' => $userId,
                'pedido_id' => $pedido->id,
                'nombre_receptor' => $validatedData['nombre_receptor'],
                'dni_receptor' => $validatedData['dni_receptor'],
                'telefono' => $validatedData['telefono'],
                'tipo_envio' => $request['tipo_envio'],
            ]);
        }

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

    public function actualizarcostoenviobd(Request $request) {

        // seteo el id de envio seleccionado que identifica para mercadopago
        Session::put('idenvio', $request["idenvio"]);
        try {
            $pedido = Pedido::find($request->id_pedido); // Cambia por el ID correspondiente
            $pedido->costo_envio = $request->costo_envio;
            $pedido->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
