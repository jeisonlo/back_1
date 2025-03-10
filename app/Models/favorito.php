<?php

// app/Models/Favorito.php
// php artisan make:model Favorito

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    use HasFactory;

  // app/Models/Favorito.php
protected $fillable = [
    'libro_id', 
    'session_id'
];

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }
    
}