<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tip;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class TipController extends Controller
{
    /**
     * Obtener todos los tips paginados
     */
    public function index()
    {
        $tips = Tip::orderBy('created_at', 'desc')->paginate(6);
        return response()->json($tips);
    }

    /**
     * Crear un nuevo tip
     */
    public function createTip(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'recommendation' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            // Subir imagen a Cloudinary
            $uploadedFile = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'tips_images',
                'transformation' => [
                    'width' => 500,
                    'height' => 500,
                    'crop' => 'limit',
                    'quality' => 'auto'
                ]
            ]);

            // Crear el tip
            $tip = Tip::create([
                'title' => $validated['title'],
                'recommendation' => $validated['recommendation'],
                'cloudinary_id' => $uploadedFile->getPublicId(),
                'image_url' => $uploadedFile->getSecurePath()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tip creado exitosamente',
                'data' => $tip
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el tip',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener un tip específico
     */
    public function getTip($id)
    {
        $tip = Tip::find($id);

        if (!$tip) {
            return response()->json([
                'success' => false,
                'message' => 'Tip no encontrado'
            ], 404);
        }

        return response()->json($tip);
    }
    public function show($id)
    {
        $tip = Tip::find($id);
        
        if (!$tip) {
            return response()->json([
                'message' => 'Tip no encontrado'
            ], 404);
        }
        
        return response()->json($tip);
    }
}