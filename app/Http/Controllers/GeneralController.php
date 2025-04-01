<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Micorreo;

class GeneralController extends Controller {

    public function contactar() {

        return view('contacto');
    }

    public function enviarConsulta(Request $request) {

        try {
            $datos = [
                'nombre' => $request["nombre"],
                'telefono' => $request["telefono"],
                'email_contacto' => $request["email"],
                'mensaje' => $request["mensaje"]
            ];

// aca va el mail donde voy a recibir las consultas hechas desde el formulario de la pagina
            Mail::to('juansartor92@gmail.com')->send(new Micorreo($datos));

            return redirect()->route('contacto')->with('success', 'Consulta enviada, nos comunicaremos con usted a la brevedad');
        } catch (Exception $e) {
            return redirect()->route('contacto')->with('failed', 'Upps no he podido enviar su consulta, intente mas tarde.');
        }
    }
}
