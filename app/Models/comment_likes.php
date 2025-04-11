<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment_likes extends Model
{
    use HasFactory;
    protected $fillable = ['comment_id'];
    
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

}
