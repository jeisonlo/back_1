<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\ejercicio;
use App\Models\exercise;
use App\Models\routine;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index()
    {
        return response()->json(Exercise::with('category')->get(), 200);
    }



    public function show($id)
    {
        $exercise = Exercise::find($id);

        if (!$exercise) {
            return response()->json(['message' => 'Ejercicio no encontrado'], 404);
        }
    
        return response()->json($exercise);
    }




    public function store(Request $request)
{
    // Validar los datos
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Máximo 5MB
        'video' => 'nullable|file|mimes:mp4,mov,avi|max:100000', // Máximo 100MB
    ]);

    try {
        // 📌 Subir imagen a Cloudinary
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image')->getRealPath();
            $uploadImage = Cloudinary::upload($imageFile, [
                'folder' => 'exercise_images', // Carpeta en Cloudinary
            ]);
            $imageUrl = $uploadImage->getSecurePath(); // Obtener URL segura de la imagen
        }

        // 📌 Subir video a Cloudinary
        $videoUrl = null;
        if ($request->hasFile('video')) {
            $videoFile = $request->file('video')->getRealPath();
            $uploadVideo = Cloudinary::upload($videoFile, [
                'resource_type' => 'video', // Especificar que es un video
                'folder' => 'exercise_videos',
            ]);
            $videoUrl = $uploadVideo->getSecurePath(); // Obtener URL segura del video
        }

        // 📌 Crear el ejercicio con URLs de imagen y video
        $exercise = Exercise::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'image_url' => $imageUrl,
            'video_url' => $videoUrl,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ejercicio creado exitosamente',
            'data' => $exercise
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error al procesar la solicitud: ' . $e->getMessage()
        ], 500);
    }
}
  public function getExercisesByIds(Request $request)
{
    $ids = explode(',', $request->query('ids'));

    $ejercicios = Exercise::whereIn('id', $ids)->get();

    return response()->json($ejercicios);
}
  
}

