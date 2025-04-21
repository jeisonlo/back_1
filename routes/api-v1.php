<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Ruta resource para AppointmentController
Route::resource('appointments', AppointmentController::class);

// Ruta resource para DocumentController
Route::resource('documents', DocumentController::class);

// Rutas
Route::resource('reports', ReportController::class);

// Ruta
Route::resource('reviews', ReviewController::class);

// Ruta
Route::resource('payments', PaymentController::class);