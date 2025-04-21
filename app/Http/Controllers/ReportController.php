<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    /**
     * Muestra todos los informes.
     */
    public function index()
    {
        $reports = Report::all();
        return response()->json(['data' => $reports], 200);
    }

    /**
     * Almacena un nuevo informe en la base de datos.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paciente_nombre' => 'required|string|max:255',
            'paciente_edad' => 'required|integer|min:0',
            'paciente_genero' => 'required|string|max:50',
            'paciente_diagnostico' => 'required|string|max:255',
            'tecnicas_pruebas_aplicadas' => 'required|string',
            'observacion' => 'required|string',
            'fecha' => 'required|date',
            'evaluador' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $report = Report::create($request->all());
    
        return response()->json([
            'message' => 'Informe guardado con éxito',
            'data' => $report,
        ], 201);
    }
    
    /**
     * Muestra un informe específico.
     */
    public function show($id)
{
    $report = Report::find($id);

    if (!$report) {
        return response()->json(['message' => 'Informe no encontrado'], 404);
    }

    return response()->json(['data' => $report], 200);
}

    /**
     * Elimina un informe de la base de datos.
     */
    public function destroy($id)
    {
        $report = Report::find($id);

        if (!$report) {
            return response()->json(['message' => 'Informe no encontrado'], 404);
        }

        $report->delete();

        return response()->json(['message' => 'Informe eliminado con éxito'], 200);
    }
}
