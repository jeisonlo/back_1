<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document; // Asegúrate de crear este modelo
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Listar todos los documentos.
     */
    public function index()
    {
        $documentos = Document::all();
        return response()->json(['data' => $documentos], 200);
    }

    /**
     * Subir un nuevo documento.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'archivo' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'profesional' => 'required|string|max:255', // Nombre del psicólogo
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Guardar el archivo
        $archivoPath = $request->file('archivo')->store('documentos', 'public');

        // Crear el documento en la base de datos
        $documento = Document::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'ruta_archivo' => $archivoPath,
            'profesional' => $request->profesional,
        ]);

        return response()->json([
            'message' => 'Archivo subido con éxito.',
            'data' => $documento,
        ], 201);
    }

    /**
     * Descargar un documento por ID.
     */
    public function show($id)
    {
        $documento = Document::find($id);

        if (!$documento) {
            return response()->json(['message' => 'Documento no encontrado'], 404);
        }

        return response()->json(['data' => $documento], 200);
    }


    public function destroy($id)
{
    $documento = Document::find($id);

    if (!$documento) {
        return response()->json(['message' => 'Documento no encontrado'], 404);
    }

    // Eliminar el archivo del almacenamiento
    Storage::disk('public')->delete($documento->ruta_archivo);

    // Eliminar el documento de la base de datos
    $documento->delete();

    return response()->json(['message' => 'Documento eliminado con éxito'], 200);
}
}