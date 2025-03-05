<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;
use App\Models\Categorialibro;

class ArteController extends Controller
{
    public function index()
    {
        // Buscar la categoría de arte o crearla si no existe
        $categoriaArte = Categorialibro::firstOrCreate(
            ['nombre' => 'Arte'],
            ['descripcion' => 'Libros de arte, pintura, escultura y otros']
        );
        
        // Obtener todos los libros de la categoría arte
        $libros = Libro::where('categorialibro_id', $categoriaArte->id)
            ->get();
            
        return view('arte.index', ['libros' => $libros]);
    }
    
    public function show($id)
    {
        $libro = Libro::find($id);
        
        if (!$libro) {
            return response()->view('errors.404', [], 404);
        }
        
        return view('arte.show', ['libro' => $libro]);
    }
}