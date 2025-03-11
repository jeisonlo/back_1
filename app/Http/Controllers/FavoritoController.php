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
    $sessionId = $request->cookie('session_id') ?? session('session_id');

    if (!$sessionId) {
        $sessionId = Str::uuid()->toString();
        session(['session_id' => $sessionId]);
    }

    // Guardar el `session_id` en una cookie
    $cookie = cookie('session_id', $sessionId, 60 * 24 * 7); // Dura 7 días

    $favoritos = Favorito::where('session_id', $sessionId)
        ->with('libro') // Cargar detalles del libro
        ->get();

    return response()->json([
        'status' => 'success',
        'data' => $favoritos,
        'session_id' => $sessionId
    ])->cookie($cookie);
}

public function store(Request $request)
{
    $request->validate([
        'libro_id' => 'required|integer|exists:libros,id',
    ]);

    $sessionId = $request->cookie('session_id') ?? session('session_id');

    if (!$sessionId) {
        $sessionId = Str::uuid()->toString();
        session(['session_id' => $sessionId]);
    }

    // Guardar el `session_id` en una cookie
    $cookie = cookie('session_id', $sessionId, 60 * 24 * 7); // Dura 7 días

    // Verificar si el libro ya está en favoritos
    $existingFavorito = Favorito::where('libro_id', $request->libro_id)
        ->where('session_id', $sessionId)
        ->first();

    if ($existingFavorito) {
        return response()->json([
            'status' => 'error',
            'message' => 'Este libro ya está en favoritos',
            'session_id' => $sessionId
        ], 422)->cookie($cookie);
    }

    // Crear el favorito
    $favorito = Favorito::create([
        'libro_id' => $request->libro_id,
        'session_id' => $sessionId,
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Libro añadido a favoritos',
        'data' => $favorito,
        'session_id' => $sessionId
    ])->cookie($cookie);
}

    
    /**
     * Eliminar un libro de favoritos
     */
    public function destroy(Request $request, $id)
    {
        $sessionId = session('session_id', $request->session_id);

if (!$sessionId) {
    $sessionId = Str::uuid()->toString();
    session(['session_id' => $sessionId]);
}

        
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
        // Get session ID directly from request parameter
        $sessionId = $request->query('session_id');
        
        if (!$sessionId) {
            return response()->json([
                'status' => 'error',
                'message' => 'No session ID provided'
            ], 400);
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