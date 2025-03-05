<?php

namespace App\Http\Controllers;

use App\Models\PromedioCalificacion;
use Illuminate\Http\Request;

class PromedioCalificacionController extends Controller
{
    public function index()
    {
        $promediocalificaciones = PromedioCalificacion::all();
        $promediocalificaciones = PromedioCalificacion::included();
        $promediocalificaciones = PromedioCalificacion::included()->get();
        $promediocalificaciones = PromedioCalificacion::included()->filter();
        $promediocalificaciones = PromedioCalificacion::included()->filter()->sort()->get();
        $promediocalificaciones = PromedioCalificacion::included()->filter()->sort()->getOrPaginate();
        return response()->json($promediocalificaciones);
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
            'promedioestrellas' => 'required|numeric|min:0|max:5',
            'numerodecalificaciones' => 'required|integer|min:0'
        ]);

        $promedio = PromedioCalificacion::updateOrCreate(
            ['libro_id' => $request->libro_id],
            [
                'promedioestrellas' => $request->promedioestrellas,
                'numerodecalificaciones' => $request->numerodecalificaciones
            ]
        );

        return response()->json($promedio, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PromedioCalificacion  $promediocalificacion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $promediocalificacion = PromedioCalificacion::findOrFail($id);
        // $promediocalificacion = PromedioCalificacion::with(['posts.user'])->findOrFail($id);
        // $promediocalificacion = PromedioCalificacion::with(['posts'])->findOrFail($id);
        // $promediocalificacion = PromedioCalificacion::included();
        // $promediocalificacion = PromedioCalificacion::included()->findOrFail($id);
        return response()->json($promediocalificacion);
        // http://api.codersfree1.test/v1/promediocalificaciones/1/?included=posts.user
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PromedioCalificacion  $promediocalificacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'promedioestrellas' => 'required|numeric|min:0|max:5',
            'numerodecalificaciones' => 'required|integer|min:0'
        ]);

        $promedio = PromedioCalificacion::where('libro_id', $id)->firstOrFail();
        $promedio->update($request->all());

        return response()->json($promedio);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PromedioCalificacion  $promediocalificacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(PromedioCalificacion $promediocalificacion)
    {
        $promediocalificacion->delete();
        return response()->json($promediocalificacion);
    }
}
