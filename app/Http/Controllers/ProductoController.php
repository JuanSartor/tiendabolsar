<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoController extends Controller {

    //
    public function indexDestacados() {
        $producto = new Producto();
        $productos = $producto->getRandom(6);
        return view('index', compact('productos'));
    }

    public function index(Request $request) {

        $search = $request->input('search'); // Obtener el término de búsqueda

        $productos = Producto::where('nombre', 'like', "%{$search}%")
                ->paginate(9); // Paginar resultados
        return view('producto.gestion', compact('productos', 'search'));
    }

    public function crear() {

        $categorias = Categoria::all(); // Obtenemos las categorías
        return view('producto.crear', compact('categorias'));
    }

    public function editar($id) {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();

        return view('producto.crear', compact('producto', 'categorias'));
    }

    public function guardar(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'alto' => 'required|numeric',
            'ancho' => 'required|numeric',
            'largo' => 'required|numeric',
            'peso' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $producto = $request->id ? Producto::findOrFail($request->id) : new Producto();

        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->categoria_id = $request->categoria;
        $producto->alto = $request->alto;
        $producto->ancho = $request->ancho;
        $producto->largo = $request->largo;
        $producto->peso = $request->peso;

        if (isset($request->id)) {
            $producto->eliminado = $request->eliminado;
        }

        // Guardar imagen si existe
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            $producto->imagen = $path;
        }

        $producto->save();

        return redirect()->route('producto.gestion')->with('success', 'Producto guardado con éxito.');
    }

    public function eliminar($id) {
        $producto = Producto::findOrFail($id);

        $producto->update([
            'eliminado' => 1,
        ]);

        session()->flash('failed', 'Producto eliminado con éxito.');

        return redirect()->route('producto.gestion');
    }

    public function ver($id) {
        $product = Producto::find($id);

        return view('producto.ver', compact('product'));
    }
}
