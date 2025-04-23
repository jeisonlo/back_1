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

use App\Http\Controllers\CanvasController;
use App\Http\Controllers\FavoritoController;
use App\Models\Favorito;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CloudinaryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EnotificationController;
use Illuminate\Routing\Route as RoutingRoute;

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExerciseLikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Models\exercise;


use App\Http\Controllers\Api\PerfilController;
use App\Http\Controllers\TipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfesionalController;
use App\Http\Controllers\RecuperacionController;
use App\Http\Controllers\UsuarioController as ControllersUsuarioController;


use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ForoController;
use App\Http\Controllers\InformacionFrutaController;
use App\Http\Controllers\ObjetivoSaludController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestBienestarController;


use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\AlbumController;
use App\Http\Controllers\Api\AudioController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\PodcastController;
use App\Http\Controllers\Api\PlaylistController;
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










Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





Route::post('/registrar-usuario', [ControllersUsuarioController::class, 'registrarUsuario']);

Route::post('/registrar-profesional', [ProfesionalController::class, 'registrarProfesional']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/solicitar-recuperacion', [RecuperacionController::class, 'solicitarRecuperacion']);

Route::post('/validar-codigo', [RecuperacionController::class, 'validarCodigo']);
Route::post('/restablecer-contrasena', [RecuperacionController::class, 'cambiarContrasena']);


Route::middleware(['auth:sanctum'])->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'show']); // GET Datos del perfil
    Route::put('/profile', [ProfileController::class, 'update']); // PUT Actualizar perfil
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto']); // POST Foto
});


   
    Route::middleware('auth:sanctum')->group(function () {
        Route::put('/users/{id}', [UserController::class, 'update']);
    });
    

    Route::get('/tips', [TipController::class, 'index']);
    Route::post('/tips/create', [TipController::class, 'createTip']);
    Route::get('/tips/{id}', [TipController::class, 'show']);


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






    //login
    Route::post('login', [LoginController::class, 'login']);

    // Géneros
    Route::get('/genres', [GenreController::class, 'index']);
    Route::post('/genres', [GenreController::class, 'store']);
    Route::get('/genres/{id}', [GenreController::class, 'show']);
    Route::put('/genres/{id}', [GenreController::class, 'update']);
    Route::delete('/genres/{id}', [GenreController::class, 'destroy']);

    // Álbumes
    Route::get('/albums', [AlbumController::class, 'index']);
    Route::post('/albums', [AlbumController::class, 'store']);
    Route::get('/albums/{id}', [AlbumController::class, 'show']);
    Route::put('/albums/{id}', [AlbumController::class, 'update']);
    Route::delete('/albums/{id}', [AlbumController::class, 'destroy']);

    // Audios
    Route::get('/audios', [AudioController::class, 'index']);
    Route::post('/audios', [AudioController::class, 'store']);
    Route::get('/audios/{id}', [AudioController::class, 'show']);
    Route::put('/audios/{id}', [AudioController::class, 'update']);
    Route::delete('/audios/{id}', [AudioController::class, 'destroy']);

    // Podcasts
    Route::get('podcasts', [PodcastController::class, 'index']);
    Route::post('podcasts', [PodcastController::class, 'store']);
    Route::get('podcasts/{podcast}', [PodcastController::class, 'show']);
    Route::put('podcasts/{id}', [PodcastController::class, 'update']);
    Route::delete('podcasts/{id}', [PodcastController::class, 'destroy']);

    // Rutas para Playlist
    Route::apiResource('playlists', PlaylistController::class);
        // Audios
        Route::post('/playlists/{playlist}/audios', [PlaylistController::class, 'addAudio']);
        Route::get('/playlists/{playlist}/audios', [PlaylistController::class, 'listAudios']);
        Route::put('/playlists/{playlist}/audios/{audio}', [PlaylistController::class, 'updateAudioOrder']);
        Route::delete('/playlists/{playlist}/audios/{audio}', [PlaylistController::class, 'removeAudio']);

        // Podcasts
        Route::post('/playlists/{playlist}/podcasts', [PlaylistController::class, 'addPodcast']);
        Route::get('/playlists/{playlist}/podcasts', [PlaylistController::class, 'listPodcasts']);
        Route::put('/playlists/{playlist}/podcasts/{podcast}', [PlaylistController::class, 'updatePodcastOrder']);
        Route::delete('/playlists/{playlist}/podcasts/{podcast}', [PlaylistController::class, 'removePodcast']);


    Route::prefix('likes')->group(function () {
        Route::post('/toggle/{audioId}', [LikeController::class, 'toggleLike']);
        Route::get('/check/{audioId}', [LikeController::class, 'checkLike']);
        Route::get('/user', [LikeController::class, 'getUserLikes']);
        Route::get('/liked', [LikeController::class, 'getAllLikedAudios']);
    });



    // use App\Http\Controllers\Api\TagController;
    // use App\Http\Controllers\Api\LikeController;
    // use App\Http\Controllers\Api\HistoryController;


// Rutas para Auth
// Route::post('register', [RegisterController::class, 'register']);
// Route::post('forgot-password', [LoginController::class, 'forgotPassword']);
// Route::post('reset-password', [LoginController::class, 'resetPassword'])->name('password.reset');


// // Rutas para Tag
// Route::apiResource('tags', TagController::class);
// // Rutas para Like
// Route::apiResource('likes', LikeController::class);
// // Rutas para History
// Route::apiResource('histories', HistoryController::class);
// // Rutas para asociar y desasociar tags con audios y podcasts
// Route::post('/audios/{audio}/tags', [TagController::class, 'attachTagToAudio']);
// Route::delete('/audios/{audio}/tags', [TagController::class, 'detachTagFromAudio']);
// Route::post('/podcasts/{podcast}/tags', [TagController::class, 'attachTagToPodcast']);
// Route::delete('/podcasts/{podcast}/tags', [TagController::class, 'detachTagFromPodcast']);

