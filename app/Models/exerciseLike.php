<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exerciseLike extends Model
{
    use HasFactory;

    protected $fillable = ['exercise_id'];
    public $timestamps = false;
}
