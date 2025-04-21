<?php

namespace App\Http\Controllers;

use App\Models\TestBienestar;
use Illuminate\Http\Request;

class TestBienestarController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'peso' => 'required|integer',
            'altura' => 'required|integer',
            'edad' => 'required|integer',
            'sexo' => 'required|in:Masculino,Femenino,Prefiero no decirlo',
            'complexion' => 'required|in:Delgada,Promedio,Musculosa,Con sobrepeso',
            'actividad' => 'required|in:Sedentario,Ligero,Moderado,Alto',
            'suenio' => 'required|in:Menos de 5,5-6,7-8,Mas de 8',
            'estres' => 'required|in:Bajo,Moderado,Alto,Muy alto',
            'objetivo' => 'required|in:Perder peso,Mantener peso,Ganar peso,Mejorar habitos alimenticios,Mejorar mi salud en general'
        ]);

        $test = TestBienestar::create($validated);

        return response()->json([
            'message' => 'Datos guardados exitosamente',
            'data' => $test
        ], 201);
    }
}