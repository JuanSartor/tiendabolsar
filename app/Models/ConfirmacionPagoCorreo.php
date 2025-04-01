<?php

namespace App\Models;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmacionPagoCorreo extends Mailable {

    use Queueable,
        SerializesModels;

    public $datos;

    public function __construct($datos) {
        $this->datos = $datos;
    }

    public function build() {
        // aca ya toma el correo configurado en el archivo env
        return $this->from(config('mail.from.address'))
                        ->subject('Ha recibido la confirmacion del pago de una compra')
                        ->view('emails.confirmacionpago')
                        ->with('datos', $this->datos);
    }
}
