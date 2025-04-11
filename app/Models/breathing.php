<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class breathing
extends Model
{
    use HasFactory;
    public function rutina(){
        return $this->hasmany('App\Models\rutina');
    }
    public function ejercicio(){   
        return $this->belongsto('App\Models\exercise');
    }
}
