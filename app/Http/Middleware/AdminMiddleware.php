<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware {

    public function handle(Request $request, Closure $next) {
        // Verifica si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirige al login si no está autenticado
        }

        // Verifica si el usuario tiene el rol de "admin"
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso denegado. No tienes permisos de administrador.');
        }

        return $next($request); // Permite el acceso si cumple las condiciones
    }
}
