<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller {

    public function miperfil() {
        $usuario = User::findOrFail(Auth::id());
        return view('user.miperfil', compact('usuario'));
    }

    public function usuarios(Request $request) {
        $search = $request->input('search');

        $usuarios = User::where('name', 'like', "%{$search}%")
                ->paginate(9); // Paginar resultados
        return view('user.usuarios', compact('usuarios', 'search'));
    }

    public function crear() {
        $usuario = User::findOrFail(Auth::id());
        return view('user.crear');
    }

    public function save(Request $request) {

        if (isset($request["bandera"])) {

            if (isset($request["banderaeditar"])) {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'surname' => 'required|string|max:255',
                ]);
            } else {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'surname' => 'required|string|max:255',
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'confirmed', Password::min(8)],
                ]);
            }
        } else {
            $request->validate([
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
            ]);
        }

        $user = $request->id ? User::findOrFail($request->id) : new User();

        $user->name = $request->name;
        $user->surname = $request->surname;
        if (isset($request["bandera"]) && !isset($request["banderaeditar"])) {
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->rol = $request->rol;
        }
        if (isset($request["bandera"]) && isset($request["banderaeditar"])) {
            $user->rol = $request->rol;
            $user->eliminado = $request->eliminado;
        }

        $user->save();

        if (isset($request["bandera"])) {
            if (isset($request["banderaeditar"])) {
                $mensaje = 'Usuario editado con éxito.';
            } else {
                $mensaje = 'Usuario creado con éxito.';
            }

            return redirect()->route('user.usuarios')->with('success', $mensaje);
        } else {
            return redirect()->route('user.miperfil')->with('success', 'Usuario editado con éxito.');
        }
    }

    public function editar($id) {
        $usuario = User::findOrFail($id);

        return view('user.crear', compact('usuario'));
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function cambiarContrasenia(Request $request) {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = auth()->user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.miperfil')->with('success', 'Contraseña actualizada con éxito.');
    }

    public function eliminar($id) {
        $usuario = User::findOrFail($id);

        $usuario->update([
            'eliminado' => 1,
        ]);
        session()->flash('success', 'Usuario eliminado con éxito.');

        return redirect()->route('user.usuarios');
    }
}
