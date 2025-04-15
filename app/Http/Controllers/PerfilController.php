<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Perfil;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\Usuario;
use App\Models\Profesional;

class PerfilController extends Controller
{
    // Actualizar perfil completo
    public function actualizarPerfil(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|in:usuario,profesional',
            'nombre' => 'required|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'viveEn' => 'required|string|max:255',
            'deDondeEs' => 'required|string|max:255',
            'estudios' => 'required|string|max:255',
            'acercaDeMi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        try {
            $tipo = $request->input('tipo');
            $modelo = $tipo === 'usuario' ? Usuario::findOrFail($id) : Profesional::findOrFail($id);
            
            $datosActualizacion = [
                'nombre' => $request->nombre,
                'apellidos' => $request->apellido,
                'vive_en' => $request->viveEn,
                'de_donde_es' => $request->deDondeEs,
                'estudios' => $request->estudios,
                'acerca_de_mi' => $request->acercaDeMi
            ];
            
            // Manejo de la imagen
            if ($request->hasFile('foto')) {
                $folder = $tipo === 'usuario' ? 'usuarios' : 'profesionales';
                $cloudinaryResponse = Cloudinary::upload($request->file('foto')->getRealPath(), [
                    'folder' => "perfiles/{$folder}/{$id}",
                    'transformation' => [
                        'width' => 500,
                        'height' => 500,
                        'crop' => 'fill'
                    ]
                ]);
                
                $datosActualizacion['foto'] = $cloudinaryResponse->getSecurePath();
            }
            
            $modelo->update($datosActualizacion);
            
            return response()->json([
                'success' => true,
                'message' => 'Perfil actualizado con éxito',
                'usuario' => $modelo->fresh()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el perfil: ' . $e->getMessage()
            ], 500);
        }
    }

    // Actualizar solo la foto
    public function actualizarFoto(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|in:usuario,profesional',
            'foto' => 'required|image|max:2048',
        ]);

        try {
            $tipo = $request->input('tipo');
            $modelo = $tipo === 'usuario' ? Usuario::findOrFail($id) : Profesional::findOrFail($id);
            
            $folder = $tipo === 'usuario' ? 'usuarios' : 'profesionales';
            $cloudinaryResponse = Cloudinary::upload($request->file('foto')->getRealPath(), [
                'folder' => "perfiles/{$folder}/{$id}",
                'transformation' => [
                    'width' => 500,
                    'height' => 500,
                    'crop' => 'fill'
                ]
            ]);
            
            $modelo->update(['foto' => $cloudinaryResponse->getSecurePath()]);
            
            return response()->json([
                'success' => true,
                'message' => 'Foto de perfil actualizada',
                'foto_url' => $cloudinaryResponse->getSecurePath()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la foto: ' . $e->getMessage()
            ], 500);
        }
    }
    public function show($id)
{
    $perfil = Perfil::where('user_id', $id)->first();

    if (!$perfil) {
        return response()->json(['error' => 'Perfil no encontrado'], 404);
    }

    return response()->json(['perfil' => $perfil]);
}
}