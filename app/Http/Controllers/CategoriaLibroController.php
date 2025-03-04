<?php

namespace App\Http\Controllers;

use App\Models\Categorialibro;
use Illuminate\Http\Request;

class CategoriaLibroController extends Controller
{
    public function index()
    {
        $categorialibros = Categorialibro::all();
        $categorialibros = Categorialibro::included();
        $categorialibros = Categorialibro::included()->get();
        $categorialibros = Categorialibro::included()->filter();
        $categorialibros = Categorialibro::included()->filter()->sort()->get();
        $categorialibros = Categorialibro::included()->filter()->sort()->getOrPaginate();
        return response()->json($categorialibros);
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
            'nombre' => 'required|max:255',
        ]);

        $categorialibros = Categorialibro::create($request->only(['nombre']));

        return response()->json($categorialibros);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categorialibro  $categorialibro
     * @return \Illuminate\Http\Response
     */
    public function showCategories()
    {
        $categorialibros = Categorialibro::all(); // Get all categories from database
        return view('categorias', ['categorias' => $categorialibros]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categorialibro  $categorialibro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categorialibro $categorialibro)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            // Elimina la validación para 'slug'
        ]);

        $categorialibro->update($request->only(['nombre']));

        return response()->json($categorialibro);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorialibro  $categorialibro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorialibro $categorialibro)
    {
        $categorialibro->delete();
        return response()->json($categorialibro);
    }
}
