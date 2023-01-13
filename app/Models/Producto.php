<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'precio',
        'marca',
        'descripcion',
        'nombre',
        'image'
    ];
    public function pedidos(){
        return $this->belongsToMany('App\Models\Pedido')->withTimestamps();
    }

}
