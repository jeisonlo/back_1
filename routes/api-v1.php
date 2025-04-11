<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CloudinaryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EnotificationController;
use Illuminate\Routing\Route as RoutingRoute;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExerciseLikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\TaskController;
use App\Models\exercise;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

Route::get('/exercises', [ExerciseController::class, 'index']);
Route::get('/exercises/{id}', [ExerciseController::class, 'show']);
Route::post('/exercises', [ExerciseController::class, 'store']);
Route::get('/exercisesByIds', [ExerciseController::class, 'getExercisesByIds']);

Route::get('/exercises', function () {
    $categoria_id = request()->query('categoria_id');
    if (!$categoria_id) {
        return response()->json(['error' => 'Falta el parámetro categoria_id'], 400);
    }
    $ejercicios = Exercise::where('category_id', $categoria_id)->get();
    return response()->json($ejercicios);
});


Route::get('/exercises/{id}', function ($id) {
    $exercise = Exercise::find($id);
    if (!$exercise) {
        return response()->json(['error' => 'Ejercicio no encontrado'], 404);
    }
    return response()->json($exercise);
});

Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::put('/tasks/{id}', [TaskController::class, 'update']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);

Route::post('/like/{exerciseId}', [ExerciseLikeController::class, 'like']);
Route::delete('/unlike/{exerciseId}', [ExerciseLikeController::class, 'unlike']);
Route::get('/liked-exercises', [ExerciseLikeController::class, 'getLikedExercises']);

Route::post('/routines', [RoutineController::class, 'store']);
Route::get('/routines/{exercise_id}', [RoutineController::class, 'show']);

Route::get('/notifications', [NotificationController::class, 'index']);
Route::post('/notifications', [NotificationController::class, 'store']);
Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);

Route::get('/comments/{exercise_id}', [CommentController::class, 'index']); // Obtener comentarios de un ejercicio
Route::post('/comments', [CommentController::class, 'store']); // Crear un nuevo comentario
Route::delete('/comments/{id}', [CommentController::class, 'destroy']);

Route::post('upload-image', [CloudinaryController::class, 'uploadImage']);
