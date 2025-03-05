<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{
    public function index(Request $request)
    {
        $calificaciones = Calificacion::all();
        $calificaciones = Calificacion::included();
        $calificaciones = Calificacion::included()->get();
        $calificaciones = Calificacion::included()->filter();
        $calificaciones = Calificacion::included()->filter()->sort()->get();
        $calificaciones = Calificacion::included()->filter()->sort()->getOrPaginate();
        $libro_id = $request->query('libro_id');
        $calificaciones = Calificacion::where('libro_id', $libro_id)->get();
        return response()->json($calificaciones);
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
            'estrellas' => 'required|numeric|min:1|max:5'
        ]);

        $calificacion = Calificacion::create($request->all());
        return response()->json($calificacion, 201);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calificacion  $calificacion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $calificacion = Calificacion::findOrFail($id);
        return response()->json($calificacion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calificacion  $calificacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calificacion $calificacion)
    {
        $request->validate([
            'estrellas' => 'required|integer|min:1|max:5', // Validación de estrellas
        ]);

        $calificacion->update($request->only(['estrellas']));

        return response()->json($calificacion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calificacion  $calificacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calificacion $calificacion)
    {
        $calificacion->delete();
        return response()->json($calificacion);
    }
}
