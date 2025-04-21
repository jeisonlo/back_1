<?php

use App\Http\Controllers\ForoController;
use App\Http\Controllers\InformacionFrutaController;
use App\Http\Controllers\ObjetivoSaludController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestBienestarController;


Route::post('/test-bienestar', [TestBienestarController::class, 'store']);

Route::get('frutas', [InformacionFrutaController::class, 'index']);
Route::get('frutas/{id}', [InformacionFrutaController::class, 'show']);

Route::post('/objetivos', [ObjetivoSaludController::class, 'store']);
Route::get('/progreso', [ObjetivoSaludController::class, 'getProgressData']);

Route::get('/foro', [ForoController::class, 'index']);
Route::post('/foro', [ForoController::class, 'store']);
Route::put('/foro/{foro}', [ForoController::class, 'update']);
Route::delete('/foro/{foro}', [ForoController::class, 'destroy']);
Route::post('/foro/{foro}/like', [ForoController::class, 'like']);
Route::post('/foro/{foro}/comentario', [ForoController::class, 'comment']);
