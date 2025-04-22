<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alimentacion;

class AlimentacionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'calorias' => 'required|numeric',
        ]);

        $registro = Alimentacion::create([
            'nombre' => $request->nombre,
            'calorias' => $request->calorias
        ]);

        return response()->json(['mensaje' => 'Datos guardados correctamente', 'data' => $registro], 201);
    }
    public function index()
    {
        return response()->json(Alimentacion::all(), 200);
    }
}