<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model {

    use HasFactory;

    protected $table = 'categorias';
    protected $fillable = ['nombre', 'id_supercategoria '];

    // una categoria tiene muchos productos, relacion  one to many

    public function productos() {
        return $this->hasMany(Producto::class, 'categoria_id');
    }

    public function supercategoria() {
        return $this->belongsTo(Supercategoria::class, 'id_supercategoria');
    }
}
