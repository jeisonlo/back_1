<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'paquete',
        'especialidad',
        'profesional',
        'fecha',
        'hora',
        'comentarios',
    ];

    // Si deseas desactivar los timestamps (created_at y updated_at)
    public $timestamps = true;
}


