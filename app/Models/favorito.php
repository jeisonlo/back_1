<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    use HasFactory;

    protected $table = 'favoritos';
    
    protected $fillable = [
        'libro_id',
        'status'
    ];

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }
}