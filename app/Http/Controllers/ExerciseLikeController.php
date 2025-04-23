<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\exerciseLike;

class ExerciseLikeController extends Controller {
    // Dar like a un ejercicio
    public function like($exerciseId) {
        // Evitar duplicados
        if (!exerciseLike::where('exercise_id', $exerciseId)->exists()) {
            exerciseLike::create([
                'exercise_id' => $exerciseId
            ]);
        }
        return response()->json(['message' => 'Like agregado'], 200);
    }

    // Quitar like a un ejercicio
    public function unlike($exerciseId) {
        exerciseLike::where('exercise_id', $exerciseId)->delete();
        return response()->json(['message' => 'Like eliminado'], 200);
    }

    // Obtener ejercicios con like
    public function getLikedExercises() {
        $likedExercises = exerciseLike::pluck('exercise_id');
        return response()->json($likedExercises);
    }
}