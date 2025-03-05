<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{

    
    public function index(Request $request)
    {
        $comentarios = Comentario::all();
        $comentarios = Comentario::included();
        $comentarios = Comentario::included()->get();
        $comentarios = Comentario::included()->filter();
        $comentarios = Comentario::included()->filter()->sort()->get();
        $comentarios = Comentario::included()->filter()->sort()->getOrPaginate();
        $libro_id = $request->query('libro_id');
        $comentarios = Comentario::where('libro_id', $libro_id)->get();
        return response()->json($comentarios);
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
            'comentario' => 'required|string|max:500',
            'libro_id' => 'required|exists:libros,id',
            'fechacreacion' => 'required|date'
        ]);

        $comentario = Comentario::create($request->all());
        return response()->json($comentario, 201);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comentario = Comentario::findOrFail($id);
        // $comentario = Comentario::with(['posts.user'])->findOrFail($id);
        // $comentario = Comentario::with(['posts'])->findOrFail($id);
        // $comentario = Comentario::included();
        // $comentario = Comentario::included()->findOrFail($id);
        return response()->json($comentario);
        // http://api.codersfree1.test/v1/comentarios/1/?included=posts.user
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comentario $comentario)
    {
        $request->validate([
            'comentario' => 'required|max:255',
            'fechacreacion' => 'required|date',
        ]);

        $comentario->update($request->only(['comentario', 'fechacreacion']));

        return response()->json($comentario);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->delete();
        return response()->json(['message' => 'Comentario eliminado']);
    }
}
