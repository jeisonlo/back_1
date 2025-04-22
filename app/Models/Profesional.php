<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Profesional extends Authenticatable
{
    use Notifiable, HasApiTokens;

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
        'vive_en',
        'de_donde_es',
        'estudios',
        'acerca_de_mi',
        'foto'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'fecha_nacimiento' => 'date',
    ];
    // Al final del modelo
protected $appends = ['foto_url'];

public function getFotoUrlAttribute()
{
    return $this->foto ?: null; // Ya tienes la URL completa guardada
}

}
