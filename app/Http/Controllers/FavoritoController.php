<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use App\Models\Libro;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favoritos = Favorito::where('status', 'active')->with('libro')->get();
        return response()->json($favoritos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'libro_id' => 'required|exists:libros,id',
        ]);

        // Check if the favorite already exists
        $existingFavorito = Favorito::where('libro_id', $request->libro_id)->first();

        if ($existingFavorito) {
            // If it exists but is inactive, activate it
            if ($existingFavorito->status === 'inactive') {
                $existingFavorito->status = 'active';
                $existingFavorito->save();
                return response()->json($existingFavorito, 200);
            }
            // If it's already active, return it
            return response()->json($existingFavorito, 200);
        }

        // Create new favorite
        $favorito = Favorito::create([
            'libro_id' => $request->libro_id,
            'status' => 'active'
        ]);

        return response()->json($favorito, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $favorito = Favorito::find($id);

        if (!$favorito) {
            return response()->json(['message' => 'Favorito no encontrado'], 404);
        }

        // Instead of deleting, we change the status to inactive
        $favorito->status = 'inactive';
        $favorito->save();

        return response()->json(['message' => 'Favorito eliminado correctamente'], 200);
    }

    /**
     * Check if a book is favorited
     *
     * @param  int  $libroId
     * @return \Illuminate\Http\Response
     */
    public function checkFavorite($libroId)
    {
        $favorito = Favorito::where('libro_id', $libroId)
                           ->where('status', 'active')
                           ->first();

        return response()->json([
            'isFavorite' => $favorito ? true : false,
            'favorito' => $favorito
        ]);
    }
}