<?php

namespace App\Http\Controllers;

use App\Models\Seguimiento;
use Illuminate\Http\Request;

class SeguimientoController extends Controller
{
    // Obtener todas las tareas
    public function index()
    {
        return response()->json(Seguimiento::all(), 200);
    }

    // Crear una nueva tarea
    public function store(Request $request)
    {
        $request->validate([
            'nombre_tarea' => 'required|string|max:255',
            'descripcion_tarea' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:tarea,en_progreso,completado',
        ]);

        $seguimiento = Seguimiento::create($request->all());

        return response()->json($seguimiento, 201);
    }

    // Obtener una tarea específica
    public function show($id)
    {
        $seguimiento = Seguimiento::find($id);
        if (!$seguimiento) {
            return response()->json(['error' => 'Seguimiento no encontrado'], 404);
        }
        return response()->json($seguimiento, 200);
    }

    // Actualizar una tarea
    public function update(Request $request, $id)
    {
        $seguimiento = Seguimiento::find($id);
        if (!$seguimiento) {
            return response()->json(['error' => 'Seguimiento no encontrado'], 404);
        }

        $request->validate([
            'nombre_tarea' => 'sometimes|string|max:255',
            'descripcion_tarea' => 'nullable|string',
            'fecha_inicio' => 'sometimes|date',
            'fecha_fin' => 'sometimes|date|after_or_equal:fecha_inicio',
            'estado' => 'sometimes|in:tarea,en_progreso,completado',
        ]);

        $seguimiento->update($request->all());

        return response()->json($seguimiento, 200);
    }

    // Eliminar una tarea
    public function destroy($id)
    {
        $seguimiento = Seguimiento::find($id);
        if (!$seguimiento) {
            return response()->json(['error' => 'Seguimiento no encontrado'], 404);
        }

        $seguimiento->delete();

        return response()->json(['message' => 'Seguimiento eliminado'], 200);
    }

    // Mover una tarea a la siguiente etapa
    public function avanzar($id)
    {
        $seguimiento = Seguimiento::find($id);
        if (!$seguimiento) {
            return response()->json(['error' => 'Seguimiento no encontrado'], 404);
        }

        $nuevoEstado = match ($seguimiento->estado) {
            'tarea' => 'en_progreso',
            'en_progreso' => 'completado',
            default => null
        };

        if (!$nuevoEstado) {
            return response()->json(['error' => 'No se puede avanzar desde completado'], 400);
        }

        $seguimiento->update(['estado' => $nuevoEstado]);

        return response()->json($seguimiento, 200);
    }

    // Regresar una tarea a la etapa anterior
    public function regresar($id)
    {
        $seguimiento = Seguimiento::find($id);
        if (!$seguimiento) {
            return response()->json(['error' => 'Seguimiento no encontrado'], 404);
        }

        $nuevoEstado = match ($seguimiento->estado) {
            'completado' => 'en_progreso',
            'en_progreso' => 'tarea',
            default => null
        };

        if (!$nuevoEstado) {
            return response()->json(['error' => 'No se puede regresar desde pendiente'], 400);
        }

        $seguimiento->update(['estado' => $nuevoEstado]);

        return response()->json($seguimiento, 200);
    }
}