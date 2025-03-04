<?php

namespace App\Http\Controllers;

use App\Models\MapadeSueno;
use Illuminate\Http\Request;

class MapaDeSuenoController extends Controller
{
    public function index()
    {
        $mapasDeSueño = MapadeSueno::all();
        $mapasDeSueño = MapadeSueno::included();
        $mapasDeSueño = MapadeSueno::included()->get();
        $mapasDeSueño = MapadeSueno::included()->filter();
        $mapasDeSueño = MapadeSueno::included()->filter()->sort()->get();
        $mapasDeSueño = MapadeSueno::included()->filter()->sort()->getOrPaginate();
        return response()->json($mapasDeSueño);
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
            'imagenes' => 'required|array',
            'texto' => 'required|string',
            'sticker' => 'nullable|string',
            'figuras' => 'nullable|array',
            'descripcion' => 'nullable|string',
        ]);

        $mapaDeSueño = MapadeSueno::create($request->only(['nombre', 'imagenes', 'texto', 'sticker', 'figuras', 'descripcion']));

        return response()->json($mapaDeSueño);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MapadeSueno  $mapadeSueño
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mapaDeSueño = MapadeSueno::findOrFail($id);
        // $mapaDeSueño = MapadeSueno::with(['posts.user'])->findOrFail($id);
        // $mapaDeSueño = MapadeSueno::with(['posts'])->findOrFail($id);
        // $mapaDeSueño = MapadeSueno::included();
        // $mapaDeSueño = MapadeSueno::included()->findOrFail($id);
        return response()->json($mapaDeSueño);
        // http://api.codersfree1.test/v1/mapadesueños/1/?included=posts.user
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MapadeSueño  $mapadeSueño
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MapadeSueno $mapadeSueño)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'imagenes' => 'required|array',
            'texto' => 'required|string',
            'sticker' => 'nullable|string',
            'figuras' => 'nullable|array',
            'descripcion' => 'nullable|string',
            // Elimina la validación para 'slug'
        ]);

        $mapadeSueño->update($request->only(['nombre', 'imagenes', 'texto', 'sticker', 'figuras', 'descripcion']));

        return response()->json($mapadeSueño);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MapadeSueño  $mapadeSueño
     * @return \Illuminate\Http\Response
     */
    public function destroy(MapadeSueno $mapadeSueño)
    {
        $mapadeSueño->delete();
        return response()->json($mapadeSueño);
    }
}
