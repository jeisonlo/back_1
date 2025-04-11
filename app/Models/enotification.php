<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enotification extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'descripcion'
    ];
    public function user(){
        return $this->belongsto('App\Models\user');
    }
}
