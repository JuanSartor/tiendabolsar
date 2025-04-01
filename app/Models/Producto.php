<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model {

    use HasFactory;

    protected $table = 'productos';
    protected $fillable = [
        'categoria_id', 'nombre', 'descripcion', 'precio', 'stock', 'oferta',
        'fecha', 'imagen', 'alto', 'ancho', 'largo', 'peso', 'eliminado'
    ];

    public function categoria() {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    //este metodo sirve para saber cuantas veces fue pedido si lo multiplicamos por la cantidad
    public function lineasPedidos() {
        return $this->hasMany(LineaPedido::class, 'producto_id');
    }

    public function getRandom($limit) {
        $productos = self::where('eliminado', 0) // Filtrar productos no eliminados
                ->where('stock', '>', 0) // Productos con stock disponible
                ->whereHas('categoria', function ($query) { // Asegurar que la categoría es visible
                    $query->where('visible', 1)
                            ->whereHas('supercategoria', function ($query) { // Asegurar que la supercategoría es visible
                                $query->where('visible', 1);
                            });
                })
                ->inRandomOrder() // Orden aleatorio
                ->limit($limit) // Limitar la cantidad de productos
                ->get();
        return $productos;
    }
}
