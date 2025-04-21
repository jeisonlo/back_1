<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjetivoSalud extends Model
{
    use HasFactory;

    protected $table = 'objetivos_salud';

    protected $fillable = [
        'descripcion',
        'fecha_objetivo',
        'peso_actual',
        'meta_peso',
        'plan_dieta'
    ];
}