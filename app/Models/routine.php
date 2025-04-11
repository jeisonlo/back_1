<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class routine extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'exercise_id',
        'descripcion',
        'video_url'
    ];
    
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}