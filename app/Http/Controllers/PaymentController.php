<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'numero_tarjeta' => 'required|string',
            'fecha_vencimiento' => 'required|string',
            'cvc' => 'required|string',
            'nombre_tarjeta' => 'required|string',
            'cc' => 'required|string',
            'monto' => 'required|numeric',
            'metodo_pago' => 'required|string',
        ]);

        // Crear el pago
        $pago = Payment::create($request->all());

        // Devolver la respuesta
        return response()->json([
            'message' => 'Pago realizado con éxito',
            'data' => $pago
        ], 201);
    }

    public function index()
    {
        // Obtener todos los pagos
        $pagos = Payment::all();

        // Devolver la respuesta
        return response()->json([
            'data' => $pagos
        ]);
    }
}
