<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['exercise_id', 'texto']; // Campos permitidos para inserción masiva

    // Relación con Exercise (Cada comentario pertenece a un ejercicio)
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
    public function likes()
{
    return $this->hasMany(comment_likes::class);
}
}
