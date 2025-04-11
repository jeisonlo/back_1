<?php

namespace App\Http\Controllers;

use App\Models\comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Obtener comentarios de un ejercicio específico.
     */
    public function index($exercise_id)
    {
        $comments = Comment::where('exercise_id', $exercise_id)->orderBy('created_at', 'desc')->get();
        return response()->json($comments);
    }

    /**
     * Guardar un nuevo comentario en un ejercicio.
     */
    public function store(Request $request)
    {
        $request->validate([
            'exercise_id' => 'required|exists:exercises,id',
            'texto' => 'required|string|max:500',
        ]);

        $comment = Comment::create([
            'exercise_id' => $request->exercise_id,
            'texto' => $request->texto,
        ]);

        return response()->json($comment, 201);
    }

    /**
     * Eliminar un comentario.
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['error' => 'Comentario no encontrado'], 404);
        }

        $comment->delete();
        return response()->json(['message' => 'Comentario eliminado'], 200);
    }
}