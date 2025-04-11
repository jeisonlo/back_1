<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Tarea;
use App\Models\task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
        // Obtener tareas por fecha
        public function index()
        {
            $tasks = task::all(); // Modelo en minúscula
            return response()->json($tasks);
        }
    
        // Crear una nueva tarea
        public function store(Request $request)
        {
            $request->validate([
                'title' => 'required|string|max:255',
                'details' => 'required|string',
            ]);
        
            $task = Task::create([
                'title' => $request->title,
                'details' => $request->details,
                'date' => $request->date ?? now()->toDateString(), // Usa la fecha actual si no se envía
            ]);
        
            return response()->json($task, 201);
        }
    
        // Actualizar una tarea
        public function update(Request $request, $id)
        {
            $task = task::findOrFail($id);
    
            $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'details' => 'sometimes|required|string',
            ]);
    
            $task->update($request->all());
    
            return response()->json($task);
        }
    
        // Eliminar una tarea
        public function destroy($id)
        {
            $task = task::findOrFail($id);
            $task->delete();
    
            return response()->json(['message' => 'Tarea eliminada'], 200);
        }
}

