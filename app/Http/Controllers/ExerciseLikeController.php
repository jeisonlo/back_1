<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExerciseLike;

class ExerciseLikeController extends Controller {
    // Dar like a un ejercicio
    public function like($exerciseId) {
        // Evitar duplicados
        if (!ExerciseLike::where('exercise_id', $exerciseId)->exists()) {
            ExerciseLike::create([
                'exercise_id' => $exerciseId
            ]);
        }
        return response()->json(['message' => 'Like agregado'], 200);
    }

    // Quitar like a un ejercicio
    public function unlike($exerciseId) {
        ExerciseLike::where('exercise_id', $exerciseId)->delete();
        return response()->json(['message' => 'Like eliminado'], 200);
    }

    // Obtener ejercicios con like
    public function getLikedExercises() {
        $likedExercises = ExerciseLike::pluck('exercise_id');
        return response()->json($likedExercises);
    }
}
