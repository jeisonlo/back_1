<?php

namespace App\Http\Controllers;

use App\Models\Foro;
use Illuminate\Http\Request;

class ForoController extends Controller
{
    public function index()
    {
        return Foro::latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'contenido' => 'required|string|max:500'
        ]);
    
        return Foro::create($request->all());
    }
    
    public function update(Request $request, Foro $foro)
    {
        $request->validate([
            'contenido' => 'required|string|max:500'
        ]);
    
        $foro->update($request->all());
        return $foro;
    }
    
    public function comment(Request $request, Foro $foro)
    {
        $request->validate([
            'texto' => 'required|string|max:200'
        ]);

        $comentarios = $foro->comentarios ?? [];
        
        $comentarios[] = [
            'autor' => 'Anónimo',
            'texto' => $request->texto,
            'fecha' => now()->toDateTimeString()
        ];

        $foro->update([
            'comentarios' => $comentarios
        ]);

        return response()->json(end($comentarios));
    }

    public function destroy(Foro $foro)
    {
        $foro->delete();
        return response()->json(null, 204);
    }

    public function like(Foro $foro)
    {
        $foro->increment('likes');
        return response()->json(['likes' => $foro->likes]);
    }
}