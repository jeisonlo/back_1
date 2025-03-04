<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;

class LibroController extends Controller


{

    public function libroPorId($id)
{
    $libro = Libro::find($id);

    if (!$libro) {
        return response()->json(['error' => 'Libro no encontrado'], 404);
    }

    return response()->json($libro);
}

    public function libro1()
    {
        $libro = Libro::find(1); // ID 1
        if (!$libro) {
            return response()->view('errors.404', [], 404);
        }
        return view('libros.libro1', ['libro' => $libro]);
    }

    public function libro2()
    {
        $libro = Libro::find(2); // ID 2
        if (!$libro) {
            return response()->view('errors.404', [], 404);
        }
        return view('libros.libro2', ['libro' => $libro]);
    }
    public function libro3()
    {
        $libro = Libro::find(3); // ID 2
        if (!$libro) {
            return response()->view('errors.404', [], 404);
        }
        return view('libros.libro3', ['libro' => $libro]);
    }

   
       // Mostrar vista del libro según el ID recibido
       public function mostrarLibro($id)
       {
           $libro = Libro::find($id);
   
           if (!$libro) {
               return response()->view('errors.404', [], 404);
           }
   
           return view('libros.show', ['libro' => $libro]);
       }
   }



