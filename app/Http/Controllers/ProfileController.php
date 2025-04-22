<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return response()->json([
            'user' => $user,
            'is_professional' => $user instanceof \App\Models\Profesional
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $commonRules = [
            'nombre' => 'sometimes|string|max:255',
            'vive_en' => 'nullable|string|max:255',
            'estudios' => 'nullable|string|max:255',
            'de_donde_es' => 'nullable|string|max:255',
            'acerca_de_mi' => 'nullable|string|max:1000',
            'fecha_nacimiento' => 'nullable|date',
        ];

        $rules = $user instanceof \App\Models\Profesional
            ? array_merge($commonRules, [
                'licencia' => 'nullable|string|max:255',
                'nivel_educativo' => 'nullable|string|max:255'
            ])
            : $commonRules;

        $validated = $request->validate($rules);

        // Parsear fecha si existe
        if (isset($validated['fecha_nacimiento'])) {
            $validated['fecha_nacimiento'] = Carbon::parse($validated['fecha_nacimiento']);
        }

        $user->update($validated);

        return response()->json([
            'user' => $user->fresh(),
            'is_professional' => $user instanceof \App\Models\Profesional
        ]);
    }

    public function updatePhoto(Request $request)
    {
        try {
            $request->validate(['photo' => 'required|image|max:2048']);
            $user = Auth::user();

            // Eliminar foto anterior si es de Cloudinary
            if ($user->foto && str_contains($user->foto, 'cloudinary')) {
                try {
                    $parsedUrl = parse_url($user->foto);
                    $path = $parsedUrl['path'] ?? null;
                    $publicId = $path ? ltrim(str_replace('/image/upload/', '', $path), '/') : null;

                    if ($publicId) {
                        Cloudinary::destroy($publicId);
                    }
                } catch (\Exception $e) {
                    Log::warning("No se pudo eliminar la foto anterior: " . $e->getMessage());
                }
            }

            // Subir nueva foto
            $file = $request->file('photo');
            $uploadResult = Cloudinary::upload($file->getRealPath(), [
                'folder' => 'profile_photos',
                'transformation' => [
                    'width' => 400,
                    'height' => 400,
                    'crop' => 'fill',
                    'quality' => 'auto'
                ]
            ]);

            $secureUrl = $uploadResult->getSecurePath();
            $user->update(['foto' => $secureUrl]);

            Log::info('Foto subida a Cloudinary', [
                'secure_url' => $secureUrl,
                'user_id' => $user->id
            ]);

            return response()->json([
                'photo_url' => $secureUrl,
                'message' => 'Foto subida correctamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al subir foto a Cloudinary: ' . $e->getMessage());

            return response()->json([
                'message' => 'Error al subir la foto: ' . $e->getMessage()
            ], 500);
        }
    }
}
