<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_nombre',
        'paciente_edad',
        'paciente_genero',
        'paciente_diagnostico',
        'tecnicas_pruebas_aplicadas',
        'observacion',
        'fecha',
        'evaluador'
    ];

    public $timestamps = true;
}

