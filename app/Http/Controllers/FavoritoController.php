<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Favorito;
use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class FavoritoController extends Controller
{
    /**
     * Obtener todos los favoritos para una sesión o usuario
     */
    public function index(Request $request)
    {
        $sessionId = $request->cookie('session_id') ?? $request->session_id;
        
        // Si no hay session_id, crear una
        if (!$sessionId) {
            $sessionId = Str::uuid()->toString();
            // En una implementación real, debes configurar una cookie aquí
        }
        
        $favoritos = Favorito::where('session_id', $sessionId)
            ->with('libro') // Eager load libro details
            ->get();
            
        return response()->json([
            'status' => 'success',
            'data' => $favoritos,
            'session_id' => $sessionId
        ]);
    }
    
    /**
     * Añadir un libro a favoritos
     */
    public function store(Request $request)
    {
        $request->validate([
            'libro_id' => 'required|integer|exists:libros,id',
        ]);
        
        $sessionId = $request->cookie('session_id') ?? $request->session_id;
        
        // Si no hay session_id, crear una
        if (!$sessionId) {
            $sessionId = Str::uuid()->toString();
            // En una implementación real, debes configurar una cookie aquí
        }
        
        // Verificar si ya existe
        $existingFavorito = Favorito::where('libro_id', $request->libro_id)
            ->where('session_id', $sessionId)
            ->first();
            
        if ($existingFavorito) {
            return response()->json([
                'status' => 'error',
                'message' => 'Este libro ya está en favoritos',
                'session_id' => $sessionId
            ], 422);
        }
        
        // Crear el favorito
        $favorito = Favorito::create([
            'libro_id' => $request->libro_id,
            'session_id' => $sessionId,
        ]);
        
        // Obtener los detalles completos del libro
        $libro = Libro::find($request->libro_id);
        $favorito->libro = $libro;
        
        return response()->json([
            'status' => 'success',
            'message' => 'Libro añadido a favoritos',
            'data' => $favorito,
            'session_id' => $sessionId
        ]);
    }
    
    /**
     * Eliminar un libro de favoritos
     */
    public function destroy(Request $request, $id)
    {
        $sessionId = $request->cookie('session_id') ?? $request->session_id;
        
        // Buscar el favorito
        $favorito = Favorito::where('libro_id', $id)
            ->where('session_id', $sessionId)
            ->first();
            
        if (!$favorito) {
            return response()->json([
                'status' => 'error',
                'message' => 'Favorito no encontrado'
            ], 404);
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
        $sessionId = $request->cookie('session_id') ?? $request->session_id;
        
        $isFavorite = Favorito::where('libro_id', $id)
            ->where('session_id', $sessionId)
            ->exists();
            
        return response()->json([
            'status' => 'success',
            'isFavorite' => $isFavorite
        ]);
    }
}