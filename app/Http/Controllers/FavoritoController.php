<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Favorito;
use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class FavoritoController extends Controller
{
    /**
     * Obtener todos los favoritos para una sesión o usuario
     */
    public function index(Request $request)
    {
        // Intentar obtener session_id de diferentes fuentes (cookie, query param, request body)
        $sessionId = $request->cookie('favoritos_session_id') ?? 
                    $request->query('session_id') ?? 
                    $request->session_id;
        
        // Si no hay session_id, crear uno nuevo
        if (!$sessionId) {
            $sessionId = Str::uuid()->toString();
        }
        
        // Obtener favoritos
        $favoritos = Favorito::where('session_id', $sessionId)
            ->get(['id', 'libro_id', 'session_id', 'created_at']);
        
        // Preparar respuesta
        $response = response()->json([
            'status' => 'success',
            'data' => $favoritos,
            'session_id' => $sessionId
        ]);
        
        // Configurar cookie si no existía previamente
        if (!$request->cookie('favoritos_session_id')) {
            $response->cookie('favoritos_session_id', $sessionId, 43200, '/', null, false, false);
        }
        
        return $response;
    }
    
    /**
     * Añadir un libro a favoritos
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'libro_id' => 'required|integer',
            ]);
            
            // Verificar si el libro existe
            $libro = Libro::find($request->libro_id);
            if (!$libro) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'El libro no existe'
                ], 404);
            }
            
            // Intentar obtener session_id de diferentes fuentes
            $sessionId = $request->cookie('favoritos_session_id') ?? 
                        $request->input('session_id');
            
            // Si no hay session_id, crear uno nuevo
            if (!$sessionId) {
                $sessionId = Str::uuid()->toString();
            }
            
            // Verificar si ya existe
            $existingFavorito = Favorito::where('libro_id', $request->libro_id)
                ->where('session_id', $sessionId)
                ->first();
            
            // Si ya existe, devolver éxito (idempotente)
            if ($existingFavorito) {
                $response = response()->json([
                    'status' => 'success',
                    'message' => 'Este libro ya está en favoritos',
                    'session_id' => $sessionId
                ]);
                
                // Asegurar que la cookie esté configurada
                $response->cookie('favoritos_session_id', $sessionId, 43200, '/', null, false, false);
                
                return $response;
            }
            
            // Crear el favorito
            $favorito = Favorito::create([
                'libro_id' => $request->libro_id,
                'session_id' => $sessionId,
            ]);
            
            // Preparar respuesta
            $response = response()->json([
                'status' => 'success',
                'message' => 'Libro añadido a favoritos',
                'data' => $favorito,
                'session_id' => $sessionId
            ]);
            
            // Configurar cookie
            $response->cookie('favoritos_session_id', $sessionId, 43200, '/', null, false, false);
            
            return $response;
        } catch (\Exception $e) {
            Log::error('Error en FavoritoController@store: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error al procesar la solicitud: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Eliminar un libro de favoritos
     */
    public function destroy(Request $request, $id)
    {
        // Obtener session_id (de cookie o query param)
        $sessionId = $request->cookie('favoritos_session_id') ?? 
                    $request->query('session_id');
        
        if (!$sessionId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Se requiere session_id'
            ], 400);
        }
        
        // Buscar el favorito
        $favorito = Favorito::where('libro_id', $id)
            ->where('session_id', $sessionId)
            ->first();
        
        // Si no existe, considerarlo como éxito (idempotente)
        if (!$favorito) {
            return response()->json([
                'status' => 'success',
                'message' => 'El libro no estaba en favoritos'
            ]);
        }
        
        // Eliminar el favorito
        $favorito->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Libro eliminado de favoritos'
        ]);
    }
    
    /**
     * Verificar si un libro está en favoritos
     */
    public function checkStatus(Request $request, $id)
    {
        // Obtener session_id (de cookie o query param)
        $sessionId = $request->cookie('favoritos_session_id') ?? 
                    $request->query('session_id');
        
        // Si no hay session_id, considerarlo como no favorito
        if (!$sessionId) {
            return response()->json([
                'status' => 'success',
                'isFavorite' => false
            ]);
        }
        
        $isFavorite = Favorito::where('libro_id', $id)
            ->where('session_id', $sessionId)
            ->exists();
        
        return response()->json([
            'status' => 'success',
            'isFavorite' => $isFavorite
        ]);
    }
}

