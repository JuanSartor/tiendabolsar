<?php

namespace App\Models;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Micorreo extends Mailable {

    use Queueable,
        SerializesModels;

    public $datos;

    public function __construct($datos) {
        $this->datos = $datos;
    }

    public function build() {
        // aca ya toma el correo configurado en el archivo env
        return $this->from(config('mail.from.address'))
                        ->subject('Consulta recibida desde el sitio web')
                        ->view('emails.contacto')
                        ->with('datos', $this->datos);
    }
}
