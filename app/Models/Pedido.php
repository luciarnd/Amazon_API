<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fecha',
        'precio_total',
        'personaReceptora',
        'direccion',
        'localidad',
        'zip',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function productos()
    {
        return $this->belongsToMany('App\Models\Producto')->withPivot('note')->withTimestamps();
}

}
