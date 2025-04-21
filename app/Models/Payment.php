<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_tarjeta', 'fecha_vencimiento', 'cvc', 'nombre_tarjeta', 'cc', 'monto', 'metodo_pago'
    ];
}
