<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfiles'; // Esto es importante si tu tabla no se llama "perfils"

    protected $fillable = [
        'user_id',
        'tipo',
        'vive_en',
        'de_donde_es',
        'estudios',
        'acerca_de_mi',
        'foto',
    ];
}
