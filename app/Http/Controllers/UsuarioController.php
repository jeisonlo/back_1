<?php

namespace App\Http\Controllers;

use App\Models\usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function registrarUsuario(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'email' => 'required|email|unique:usuarios',
            'password' => 'required|string|min:8',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|string'
        ]);

        $usuario = usuario::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero' => $request->genero
        ]);

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'usuario' => $usuario
        ], 201);
    }
}