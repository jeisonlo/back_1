<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestBienestar extends Model
{
    use HasFactory;

    protected $table = 'test_bienestars';

    protected $fillable = [
        'peso',
        'altura',
        'edad',
        'sexo',
        'complexion',
        'actividad',
        'suenio',
        'estres',
        'objetivo',
    ];
}
