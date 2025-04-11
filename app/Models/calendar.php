<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class calendar extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo('App\Models\user');
    }
    public function historial(){
        return $this->belongsTo('App\Models\historial');
    }
    public function notificacion(){
        return $this->belongsTo('App\Models\enotification');
    }
    public function tarea(){
        return $this->belongsTo('App\Models\tarea');
    }

}
