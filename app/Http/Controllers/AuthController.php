<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\usuario;
use App\Models\Profesional;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        // Buscar en la tabla de usuarios
        $usuario = usuario::where('email', $request->email)->first();
        if ($usuario && Hash::check($request->password, $usuario->password)) {
            $token = $usuario->createToken('usuario_token')->plainTextToken;
            return response()->json([
                'message' => 'Usuario autenticado',
                'tipo' => 'usuario',
                'token' => $token,
                'user' => $usuario
            ], 200);
        }

        // Buscar en la tabla de profesionales
        $profesional = Profesional::where('email', $request->email)->first();
        if ($profesional && Hash::check($request->password, $profesional->password)) {
            $token = $profesional->createToken('profesional_token')->plainTextToken;
            return response()->json([
                'message' => 'Profesional autenticado',
                'tipo' => 'profesional',
                'token' => $token,
                'user' => $profesional
            ], 200);
        }

        // Si no encontró nada válido
        return response()->json([
            'message' => 'Correo o contraseña incorrectos'
        ], 401);
    }
}
