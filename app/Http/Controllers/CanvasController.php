<?php

namespace App\Http\Controllers;

use App\Models\Canvas;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Validator;

class CanvasController extends Controller
{
    /**
     * Listar todos los lienzos
     */
    public function index()
    {
        $canvases = Canvas::latest()->get();
        return response()->json([
            'success' => true,
            'data' => $canvases
        ]);
    }

    /**
     * Guardar un nuevo lienzo
     */
    public function store(Request $request)
    {
        // Validar datos
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'required|string', // Base64 de la imagen
            'canvas_data' => 'required|json' // JSON del canvas
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Decodificar imagen base64
            $imageData = $request->image;
            // Aseguramos que la imagen base64 es solo el contenido sin el data:image/png;base64,
            if (strpos($imageData, ';base64,') !== false) {
                $imageData = explode(';base64,', $imageData)[1];
            }

            // Subir a Cloudinary
            $uploadedFileUrl = Cloudinary::upload("data:image/png;base64," . $imageData, [
                "folder" => "canvas_designs",
                "public_id" => "canvas_" . time(),
                "overwrite" => true
            ]);

            // Crear registro en la base de datos
            $canvas = Canvas::create([
                'title' => $request->title,
                'cloudinary_id' => $uploadedFileUrl->getPublicId(),
                'cloudinary_url' => $uploadedFileUrl->getSecurePath(),
                'canvas_data' => $request->canvas_data
            ]);

            return response()->json([
                'success' => true,
                'message' => '¡Lienzo guardado con éxito!',
                'data' => $canvas
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el lienzo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un lienzo específico
     */
    public function show($id)
    {
        $canvas = Canvas::find($id);
        
        if (!$canvas) {
            return response()->json([
                'success' => false,
                'message' => 'Lienzo no encontrado'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $canvas
        ]);
    }

    /**
     * Actualizar un lienzo
     */
    public function update(Request $request, $id)
    {
        // Validar datos
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'image' => 'sometimes|string', // Base64 de la imagen
            'canvas_data' => 'sometimes|json' // JSON del canvas
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $canvas = Canvas::find($id);
        
        if (!$canvas) {
            return response()->json([
                'success' => false,
                'message' => 'Lienzo no encontrado'
            ], 404);
        }

        try {
            $data = [];
            
            // Actualizar título si se proporciona
            if ($request->has('title')) {
                $data['title'] = $request->title;
            }
            
            // Actualizar canvas_data si se proporciona
            if ($request->has('canvas_data')) {
                $data['canvas_data'] = $request->canvas_data;
            }
            
            // Actualizar imagen si se proporciona
            if ($request->has('image')) {
                // Decodificar imagen base64
                $imageData = $request->image;
                // Aseguramos que la imagen base64 es solo el contenido sin el data:image/png;base64,
                if (strpos($imageData, ';base64,') !== false) {
                    $imageData = explode(';base64,', $imageData)[1];
                }

                // Si ya tiene una imagen en Cloudinary, la reemplazamos
                if ($canvas->cloudinary_id) {
                    // Actualizar la imagen existente
                    $uploadedFileUrl = Cloudinary::upload("data:image/png;base64," . $imageData, [
                        "public_id" => $canvas->cloudinary_id,
                        "overwrite" => true
                    ]);
                } else {
                    // Subir como nueva imagen
                    $uploadedFileUrl = Cloudinary::upload("data:image/png;base64," . $imageData, [
                        "folder" => "canvas_designs",
                        "public_id" => "canvas_" . time(),
                        "overwrite" => true
                    ]);
                    
                    $data['cloudinary_id'] = $uploadedFileUrl->getPublicId();
                }
                
                $data['cloudinary_url'] = $uploadedFileUrl->getSecurePath();
            }
            
            // Actualizar el lienzo
            $canvas->update($data);

            return response()->json([
                'success' => true,
                'message' => '¡Lienzo actualizado con éxito!',
                'data' => $canvas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el lienzo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un lienzo
     */
    public function destroy($id)
    {
        $canvas = Canvas::find($id);
        
        if (!$canvas) {
            return response()->json([
                'success' => false,
                'message' => 'Lienzo no encontrado'
            ], 404);
        }

        try {
            // Eliminar imagen de Cloudinary si existe
            if ($canvas->cloudinary_id) {
                Cloudinary::destroy($canvas->cloudinary_id);
            }
            
            // Eliminar registro de la base de datos
            $canvas->delete();

            return response()->json([
                'success' => true,
                'message' => '¡Lienzo eliminado con éxito!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el lienzo',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}