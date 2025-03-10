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
        try {
            // Intentar obtener session_id de diferentes fuentes 
            $sessionId = $request->cookie('favoritos_session_id') ?? 
                        $request->query('session_id') ?? 
                        $request->input('session_id');
            
            Log::info('Obteniendo favoritos', ['session_id' => $sessionId]);
            
            // Si no hay session_id, crear uno nuevo
            if (!$sessionId) {
                $sessionId = Str::uuid()->toString();
                Log::info('Generando nuevo session_id', ['session_id' => $sessionId]);
            }
            
            // Obtener favoritos
            $favoritos = Favorito::where('session_id', $sessionId)
                ->get(['id', 'libro_id', 'session_id', 'created_at']);
            
            Log::info('Favoritos obtenidos', ['count' => count($favoritos)]);
            
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
        } catch (\Exception $e) {
            Log::error('Error en FavoritoController@index: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener favoritos: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Añadir un libro a favoritos
     */
    public function store(Request $request)
    {
        try {
            // Log the full request for debugging
            Log::info('Recibida solicitud para añadir favorito', [
                'request_data' => $request->all(),
                'headers' => $request->headers->all()
            ]);
    
            // Validar datos de entrada
            $validatedData = $request->validate([
                'libro_id' => 'required|integer',
                'session_id' => 'required|string'
            ]);
            
            $libroId = $validatedData['libro_id'];
            $sessionId = $validatedData['session_id'];
            
            // Verificar si el libro existe
            $libro = Libro::find($libroId);
            if (!$libro) {
                Log::warning('Intento de añadir favorito de libro inexistente', [
                    'libro_id' => $libroId
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'El libro no existe'
                ], 404);
            }
            
            Log::info('Libro encontrado, procesando favorito', [
                'libro_id' => $libroId,
                'session_id' => $sessionId
            ]);
            
            // Verificar si ya existe
            $existingFavorito = Favorito::where('libro_id', $libroId)
                ->where('session_id', $sessionId)
                ->first();
            
            // Si ya existe, devolver éxito (idempotente)
            if ($existingFavorito) {
                Log::info('El favorito ya existía', [
                    'favorito_id' => $existingFavorito->id
                ]);
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Este libro ya está en favoritos',
                    'data' => $existingFavorito,
                    'session_id' => $sessionId
                ]);
            }
            
            // Crear el favorito
            $favorito = new Favorito();
            $favorito->libro_id = $libroId;
            $favorito->session_id = $sessionId;
            
            // Ensure we're not missing any required fields
            Log::info('Favorito object before save', [
                'libro_id' => $favorito->libro_id,
                'session_id' => $favorito->session_id,
                'model_fields' => array_keys($favorito->getAttributes())
            ]);
            
            $favorito->save();
            
            Log::info('Favorito creado exitosamente', [
                'favorito_id' => $favorito->id
            ]);
            
            // Preparar respuesta
            return response()->json([
                'status' => 'success',
                'message' => 'Libro añadido a favoritos',
                'data' => $favorito,
                'session_id' => $sessionId
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Error de validación en FavoritoController@store', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Datos de entrada inválidos',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error en FavoritoController@store: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'error_line' => $e->getLine(),
                'error_file' => $e->getFile()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al procesar la solicitud: ' . $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
    /**
     * Eliminar un libro de favoritos
     */
    public function destroy(Request $request, $id)
    {
        try {
            // Obtener session_id (de cookie o query param)
            $sessionId = $request->cookie('favoritos_session_id') ?? 
                        $request->query('session_id');
            
            if (!$sessionId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Se requiere session_id'
                ], 400);
            }
            
            Log::info('Eliminando favorito', [
                'libro_id' => $id,
                'session_id' => $sessionId
            ]);
            
            // Buscar el favorito
            $favorito = Favorito::where('libro_id', $id)
                ->where('session_id', $sessionId)
                ->first();
            
            // Si no existe, considerarlo como éxito (idempotente)
            if (!$favorito) {
                Log::info('El favorito no existía', [
                    'libro_id' => $id,
                    'session_id' => $sessionId
                ]);
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'El libro no estaba en favoritos'
                ]);
            }
            
            // Eliminar el favorito
            $favorito->delete();
            
            Log::info('Favorito eliminado exitosamente', [
                'libro_id' => $id
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Libro eliminado de favoritos'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en FavoritoController@destroy: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al eliminar favorito: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Verificar si un libro está en favoritos
     */
    public function checkStatus(Request $request, $id)
    {
        try {
            // Obtener session_id (de cookie o query param)
            $sessionId = $request->cookie('favoritos_session_id') ?? 
                        $request->query('session_id');
            
            Log::info('Verificando estado de favorito', [
                'libro_id' => $id,
                'session_id' => $sessionId
            ]);
            
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
            
            Log::info('Estado de favorito obtenido', [
                'libro_id' => $id,
                'isFavorite' => $isFavorite
            ]);
            
            return response()->json([
                'status' => 'success',
                'isFavorite' => $isFavorite
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en FavoritoController@checkStatus: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al verificar estado de favorito: ' . $e->getMessage()
            ], 500);
        }
    }
}