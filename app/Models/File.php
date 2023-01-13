<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'producto_id',
        'file_path',
    ];

    public function producto() {
        return $this->belongsTo(Producto::class);
    }
}
