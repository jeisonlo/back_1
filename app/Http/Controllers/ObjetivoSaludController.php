<?php

namespace App\Http\Controllers;

use App\Models\ObjetivoSalud;
use Illuminate\Http\Request;

class ObjetivoSaludController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'fecha_objetivo' => 'required|date',
            'peso_actual' => 'required|numeric|between:20,200',
            'meta_peso' => 'required|numeric|between:20,200'
        ]);

        $diferencia = $validated['meta_peso'] - $validated['peso_actual'];
        
        $validated['plan_dieta'] = $diferencia < 0 
            ? $this->generarPlanPerdidaPeso(abs($diferencia))
            : $this->generarPlanGananciaPeso($diferencia);

        $objetivo = ObjetivoSalud::create($validated);

        return response()->json([
            'mensaje' => 'Objetivo guardado exitosamente',
            'data' => $objetivo
        ], 201);
    }

    private function generarPlanPerdidaPeso($kg)
    {
        $planes = [
            'Dieta baja en carbohidratos + 30min cardio diario',
            'Déficit calórico 500kcal + Entrenamiento fuerza',
            'Ayuno intermitente 16/8 + Dieta mediterránea'
        ];
        return $planes[array_rand($planes)] . " (-$kg kg)";
    }

    private function generarPlanGananciaPeso($kg)
    {
        $planes = [
            'Superávit 500kcal + Rutina pesas 5 días',
            '6 comidas diarias + Batidos proteicos',
            'Suplementación creatina + Dieta hiperproteica'
        ];
        return $planes[array_rand($planes)] . " (+$kg kg)";
    }

    public function getProgressData()
    {
        try {
            $objetivos = ObjetivoSalud::latest()->take(3)->get();

            return response()->json([
                'meta_actual' => $objetivos->first()->meta_peso ?? null,
                'peso_actual' => $objetivos->first()->peso_actual ?? null,
                'historial' => $objetivos->reverse()->values(),
                'evolucion' => $objetivos->pluck('peso_actual')->toArray()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'meta_actual' => null,
                'peso_actual' => null,
                'historial' => [],
                'evolucion' => []
            ]);
        }
    }
}