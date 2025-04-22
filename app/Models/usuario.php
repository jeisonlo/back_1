<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class usuario extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'password',
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
        'fecha_nacimiento' => 'date',
    ];
    protected $appends = ['foto_url'];

public function getFotoUrlAttribute()
{
    return $this->foto ?: null; // Ya tienes la URL completa guardada
}
}
