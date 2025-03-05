<?php

use App\Http\Controllers\Api\FavoritoController as ApiFavoritoController;
use App\Http\Controllers\ArteController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\CategoriaLibroController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\MapaDeSuenoController;
use App\Http\Controllers\PromedioCalificacionController;
use App\Http\Controllers\SeguimientoController;
use App\Models\Categorialibro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CanvasController;
use App\Http\Controllers\FavoritoController;
use App\Models\Favorito;

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
Route::get('/', function () {
    return view('welcome');
});
Route::get('/prueba', function () {
    return 'prueba';
});

  Route::resource('canvases', CanvasController::class);
  Route::get('categorias', [CategoriaLibroController::class, 'showCategories'])->name('categorias.index');
Route::post('categorialibros', [CategoriaLibroController::class, 'store'])->name('api.v1.categorialibros.store');
Route::get('categorialibros', [CategoriaLibroController::class, 'index'])->name('api.v1.categorialibros.index');
Route::get('categorialibros/{categorialibro}', [CategoriaLibroController::class, 'show'])->name('api.v1.categorialibros.show');
Route::put('categorialibros/{categorialibro}', [CategoriaLibroController::class, 'update'])->name('api.v1.categorialibros.update');
Route::delete('categorialibros/{categorialibro}', [CategoriaLibroController::class, 'destroy'])->name('api.v1.categorialibros.destroy');
//Rutas para las calificaciones
Route::post('calificaciones', [CalificacionController::class, 'store'])->name('api.v1.calificaciones.store');
Route::get('calificaciones', [CalificacionController::class, 'index'])->name('api.v1.calificaciones.index');
Route::get('calificaciones/{calificacion}', [CalificacionController::class, 'show'])->name('api.v1.calificaciones.show');
Route::put('calificaciones/{calificacion}', [CalificacionController::class, 'update'])->name('api.v1.calificaciones.update');
Route::delete('calificaciones/{calificacion}', [CalificacionController::class, 'destroy'])->name('api.v1.calificaciones.destroy');
//Rutas para los comentarios
Route::post('comentarios', [ComentarioController::class, 'store'])->name('api.v1.comentarios.store');
Route::get('comentarios', [ComentarioController::class, 'index'])->name('api.v1.comentarios.index');
Route::get('comentarios/{comentario}', [ComentarioController::class, 'show'])->name('api.v1.comentarios.show');
Route::put('comentarios/{comentario}', [ComentarioController::class, 'update'])->name('api.v1.comentarios.update');
Route::delete('comentarios/{comentario}', [ComentarioController::class, 'destroy'])->name('api.v1.comentarios.destroy');

Route::get('/libro1', [LibroController::class, 'libro1']);
Route::get('/libro2', [LibroController::class, 'libro2']);
Route::get('/libro3', [LibroController::class, 'libro3']);
// For API/JSON response
Route::get('/api/libros/{id}', [LibroController::class, 'libroPorId']);

// For view rendering
Route::get('/libros/{id}', [LibroController::class, 'mostrarLibro']);


//Rutas para el mapa de sueños
Route::post('mapadesueños', [MapaDeSuenoController::class, 'store'])->name('api.v1.mapadesueños.store');
Route::get('mapadesueños', [MapaDeSuenoController::class, 'index'])->name('api.v1.mapadesueños.index');
Route::get('mapadesueños/{mapadesueno}', [MapaDeSuenoController::class, 'show'])->name('api.v1.mapadesueños.show');
Route::put('mapadesueños/{mapadesueno}', [MapaDeSuenoController::class, 'update'])->name('api.v1.mapadesueños.update');
Route::delete('mapadesueños/{mapadesueno}', [MapaDeSuenoController::class, 'destroy'])->name('api.v1.mapadesueños.destroy');
//Rutas para el promedio calificacion del libro
Route::post('promediocalificacion', [PromedioCalificacionController::class, 'store'])->name('api.v1.promediocalificacion.store');
Route::get('promediocalificacion', [PromedioCalificacionController::class, 'index'])->name('api.v1.promediocalificacion.index');
Route::get('promediocalificacion/{promediocalificacion}', [PromedioCalificacionController::class, 'show'])->name('api.v1.promediocalificacion.show');
Route::put('promediocalificacion/{promediocalificacion}', [PromedioCalificacionController::class, 'update'])->name('api.v1.promediocalificacion.update');
Route::delete('promediocalificacion/{promediocalificacion}', [PromedioCalificacionController::class, 'destroy'])->name('api.v1.promediocalificacion.destroy');
//Ruta para seguimiento de mapa de sueños
Route::get('/seguimiento', [SeguimientoController::class, 'index']);
Route::post('/seguimiento', [SeguimientoController::class, 'store']);
Route::delete('/seguimiento/{id}', [SeguimientoController::class, 'destroy']);
Route::put('/seguimiento/avanzar/{id}', [SeguimientoController::class, 'avanzar']);
Route::put('/seguimiento/regresar/{id}', [SeguimientoController::class, 'regresar']);


// Rutas para la sección de Arte
Route::get('/arte', [ArteController::class, 'index'])->name('arte.index');
Route::get('/arte/{id}', [ArteController::class, 'show'])->name('arte.show');

// Rutas para los favoritos
Route::get('/favoritos', [FavoritoController::class, 'index']);
Route::post('/favoritos', [FavoritoController::class, 'store']);
Route::delete('/favoritos/{id}', [FavoritoController::class, 'destroy']);
Route::get('/favoritos/check/{id}', [FavoritoController::class, 'checkStatus']);
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  //  return $request->user();
//});
