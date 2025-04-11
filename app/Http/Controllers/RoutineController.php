<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\Routine
;
class RoutineController extends Controller
{
   
public function store(Request $request)
{
    // Validar la solicitud
    $request->validate([
        'exercise_id' => 'required|exists:exercises,id',
        'descripcion' => 'required|string',
        'video' => 'required|file|mimes:mp4,mov,avi|max:100000',
    ]);

    // Verificar que el archivo existe
    if (!$request->hasFile('video')) {
        return response()->json(['error' => 'El archivo de video no se recibió'], 400);
    }

    if (!$request->file('video')->isValid()) {
        return response()->json(['error' => 'El archivo de video no es válido'], 400);
    }

    try {
        // Obtener el archivo
        $videoFile = $request->file('video');
        $videoPath = $videoFile->getRealPath();

        Log::info('Subiendo archivo: ' . $videoFile->getClientOriginalName());
        Log::info('Ruta temporal: ' . $videoPath);

        // Subir a Cloudinary
        $uploadResult = Cloudinary::uploadVideo($videoPath, [
            'folder' => 'exercise_videos',
            'public_id' => 'exercise_' . $request->exercise_id . '_' . time()
        ]);

        Log::info('Respuesta de Cloudinary: ', ['response' => json_decode(json_encode($uploadResult), true)]);


        if (null === $uploadResult->getSecurePath()) {
            return response()->json(['error' => 'No se pudo obtener la URL del video'], 500);
        }

        // Crear nueva rutina
        $routine = new Routine();
        $routine->exercise_id = $request->exercise_id;
        $routine->descripcion = $request->descripcion;
        $routine->video_url = $uploadResult->getSecurePath();

        if ($routine->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Rutina creada exitosamente',
                'data' => $routine
            ], 201);
        } else {
            return response()->json(['error' => 'No se pudo guardar la rutina'], 500);
        }
    } catch (\Exception $e) {
        Log::error('Error en RoutineController::store: ' . $e->getMessage());
        return response()->json(['error' => 'Error al procesar la solicitud: ' . $e->getMessage()], 500);
    }
}







public function show($exercise_id)
{
    // Buscar todas las rutinas asociadas al exercise_id
    $routines = Routine::where('exercise_id', $exercise_id)->get();

    // Verificar si hay rutinas disponibles
    if ($routines->isEmpty()) {
        return response()->json(['message' => 'Rutina no encontrada'], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $routines
    ]);
}
}