<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class informacionFruta extends Model
{
    use HasFactory;

    protected $table = 'informacion_frutas';

    protected $fillable = [
        'fruta',
        'imagen',
        'descripcion',
        'clasificacion',
        'peso_promedio',
        'color',
        'usos'
    ];
}