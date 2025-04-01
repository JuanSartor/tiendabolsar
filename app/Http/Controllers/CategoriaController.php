<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Supercategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller {

    public function index(Request $request) {


        $search = $request->input('search'); // Obtener el término de búsqueda

        $categorias_t = Categoria::where('nombre', 'like', "%{$search}%")
                ->paginate(10); // Paginar resultados

        return view('categoria.index', compact('categorias_t', 'search'));
    }

    public function crear() {

        $supercategorias_abm = Supercategoria::all();

        return view('categoria.crear', compact('supercategorias_abm'));
    }

    public function editar($id) {
        $categoria = Categoria::findOrFail($id);

        $supercategorias_abm = Supercategoria::all();

        return view('categoria.crear', compact('supercategorias_abm', 'categoria'));
    }

    public function ver($id) {

        $categoria = Categoria::findOrFail($id);

        if (!$categoria) {
            return view('categoria.no-existe');
        }

        $productos = Producto::where('categoria_id', $id)
                ->where('eliminado', 0)
                ->where('stock', '>', 0)
                ->paginate(9);

        return view('categoria.ver', compact('categoria', 'productos'));
    }

    public function save(Request $request) {


// Comprobar si el usuario es administrador (puedes ajustarlo según tu lógica)
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Acceso no autorizado'], 403);
        }

        // Validación del campo 'nombre'
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'supercategoria' => 'required|exists:supercategoria,id',
        ]);

        // Guardar la categoría en la base de datos
        $categoria = $request->id ? Categoria::findOrFail($request->id) : new Categoria();
        $categoria->nombre = $validatedData['nombre'];
        $categoria->visible = $request->visible;

        $categoria->id_supercategoria = $request->supercategoria;

        if ($categoria->save()) {
            return redirect('/categorias');
        }

        return response()->json(['error' => 'Error al guardar la categoría'], 500);
    }

    public function eliminar($id) {

        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('categoria.index')->with('success', 'Categoria eliminada con éxito.');
    }
}
