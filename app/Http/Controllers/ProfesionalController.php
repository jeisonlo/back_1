<?php

namespace App\Http\Controllers;

use App\Models\Profesional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfesionalController extends Controller
{
    public function registrarProfesional(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:profesionales',
            'password' => 'required|string|min:8',
            'licencia' => 'required|string|unique:profesionales',
            'nivel_educativo' => 'required|in:Psicólogo,Psiquiatra,Terapeuta,Counselor',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:Mujer,Hombre,Personalizado'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $profesional = Profesional::create($validated);

        return response()->json([
            'message' => 'Profesional registrado exitosamente',
            'profesional' => $profesional
        ], 201);
    }
}