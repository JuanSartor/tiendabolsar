<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envio extends Model {

    use HasFactory;

    protected $table = 'envio';
    protected $fillable = ['user_id', 'pedido_id', 'provincia', 'localidad', 'direccion',
        'nombre_receptor', 'dni_receptor', 'tipo_envio', 'telefono', 'codigo_postal'];

    // una categoria tiene muchos productos, relacion  one to many

    public function usuario() {
        return $this->belongsTo(User::class);
    }

    public function pedido() {
        return $this->belongsTo(Pedido::class);
    }
}
