<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Añadir esta línea

class Profesional extends Authenticatable {
    use Notifiable, HasApiTokens; // Añadir HasApiTokens

    // Agrega esta propiedad para especificar el nombre de la tabla
    protected $table = 'profesionales';

    protected $fillable = [
        'nombre',
    'apellidos',
    'email',
    'password',
    'licencia',
    'nivel_educativo',
    'fecha_nacimiento',
    'genero',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'fecha_nacimiento' => 'date',
    ];
}