<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canvas extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'cloudinary_id',
        'cloudinary_url',
        'canvas_data'
    ];

    protected $casts = [
        'canvas_data' => 'json',
    ];
}
