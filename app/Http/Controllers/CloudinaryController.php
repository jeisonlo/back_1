<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CloudinaryController extends Controller
{
    public function uploadImage(Request $request)
    {
        // Validar el archivo de la solicitud
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:10240', // máximo 10MB
        ]);

        // Subir el archivo a Cloudinary
        $image = $request->file('image');
        
        try {
            $uploadResult = Cloudinary::upload($image->getRealPath(), [
                'folder' => 'mi-app', // Opcional: puedes especificar un folder
            ]);

            // Retornar la URL de la imagen subida
            return response()->json([
                'url' => $uploadResult->getSecurePath(), // Asegúrate de obtener el método adecuado para la URL segura
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al subir la imagen: ' . $e->getMessage(),
            ], 500);
        }
    }
}

