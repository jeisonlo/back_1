<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foro extends Model
{
    protected $fillable = [
        'nombre', 
        'contenido',
        'likes',
        'comentarios'
    ];

    protected $casts = [
        'comentarios' => 'array', // Agregar casting para JSON
    ];
}
