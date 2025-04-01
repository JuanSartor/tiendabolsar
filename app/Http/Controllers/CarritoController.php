<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Session;

class CarritoController extends Controller {

    public function index() {
        // Obtener el carrito de la sesión, si no existe, asignar un array vacío
        $carrito = Session::get('carrito', []);

        return view('carrito.index', compact('carrito'));
    }

    public function agregar($id) {


        $producto = Producto::findOrFail($id);

        // Obtener el carrito actual de la sesión
        $carrito = Session::get('carrito', []);

        // Verificar si el producto ya está en el carrito
        $encontrado = false;

        foreach ($carrito as &$item) {
            if ($item['id_producto'] == $producto->id) {
                $item['unidades']++;
                $encontrado = true;
                break;
            }
        }

        // Si no está en el carrito, añadirlo
        if (!$encontrado) {
            $carrito[] = [
                "id_producto" => $producto->id,
                "precio" => $producto->precio,
                "unidades" => 1,
                "producto" => $producto->toArray()
            ];
        }

        // Guardar el carrito actualizado en la sesión
        Session::put('carrito', $carrito);

        return redirect()->route('carrito.index')->with('success', 'Producto agregado al carrito.');
    }

    public function eliminar($index) {
        $carrito = Session::get('carrito', []);
        unset($carrito[$index]);
        Session::put('carrito', $carrito);

        return redirect()->route('carrito.index');
    }

    public function vaciar() {
        Session::forget('carrito');
        return redirect()->route('carrito.index');
    }

    public function incrementar($index) {
        $carrito = Session::get('carrito', []);
        $carrito[$index]['unidades']++;
        Session::put('carrito', $carrito);

        return redirect()->route('carrito.index');
    }

    public function decrementar($index) {
        $carrito = Session::get('carrito', []);
        if ($carrito[$index]['unidades'] > 1) {
            $carrito[$index]['unidades']--;
        } else {
            unset($carrito[$index]);
        }

        Session::put('carrito', $carrito);

        return redirect()->route('carrito.index');
    }
}
