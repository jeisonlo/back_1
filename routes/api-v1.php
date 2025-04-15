<?php

use App\Http\Controllers\Api\PerfilController;
use App\Http\Controllers\TipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfesionalController;
use App\Http\Controllers\RecuperacionController;
use App\Http\Controllers\UsuarioController as ControllersUsuarioController;
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


Route::post('/registrar-usuario', [ControllersUsuarioController::class, 'registrarUsuario']);

Route::post('/registrar-profesional', [ProfesionalController::class, 'registrarProfesional']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/solicitar-recuperacion', [RecuperacionController::class, 'solicitarRecuperacion']);

Route::post('/validar-codigo', [RecuperacionController::class, 'validarCodigo']);
Route::post('/restablecer-contrasena', [RecuperacionController::class, 'cambiarContrasena']);



Route::post('/perfil/{id}/actualizar', [PerfilController::class, 'actualizarPerfil'])
    ->middleware('auth:sanctum');

// Ruta para actualizar solo la foto
Route::post('/perfil/{id}/actualizar-foto', [PerfilController::class, 'actualizarFoto'])
    ->middleware('auth:sanctum');


    use App\Http\Controllers\UserController;
    Route::middleware('auth:sanctum')->group(function () {
        Route::put('/users/{id}', [UserController::class, 'update']);
    });
    

    Route::get('/tips', [TipController::class, 'index']);
    Route::post('/tips/create', [TipController::class, 'createTip']);
    Route::get('/tips/{id}', [TipController::class, 'show']);