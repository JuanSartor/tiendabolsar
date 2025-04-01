<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineaPedido extends Model {

    use HasFactory;

    protected $table = 'lineas_pedidos';
    protected $fillable = ['pedido_id', 'producto_id', 'unidades'];

    public function pedido() {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function producto() {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
