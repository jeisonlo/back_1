<?php

namespace App\Http\Controllers;

use App\Models\Profesional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Usuario;

class RecuperacionController extends Controller
{
    public function solicitarRecuperacion(Request $request)
    {
        // Validación del formato de email
        $request->validate([
            'email' => 'required|email',
        ]);
    
        $email = $request->email;
    
        // Buscar si existe en usuarios
        $usuario = Usuario::where('email', $email)->first();
    
        // Buscar si existe en profesionales
        $profesional = Profesional::where('email', $email)->first();
    
        // Si no se encuentra en ninguna tabla
        if (!$usuario && !$profesional) {
            return response()->json([
                'message' => 'El correo no está registrado en el sistema.'
            ], 422);
        }
    
        // Generar código aleatorio
        $codigo = rand(100000, 999999); // Ej: 6 dígitos
    
        if ($usuario) {
            $usuario->codigo_recuperacion = $codigo;
            $usuario->save();
        } else {
            $profesional->codigo_recuperacion = $codigo;
            $profesional->save();
        }
    
        // Aquí podrías enviar el código al correo (esto es opcional)
        // Mail::to($email)->send(new CodigoRecuperacionMail($codigo));
    
        return response()->json([
            'message' => 'Código de recuperación enviado correctamente.',
            'codigo' => $codigo, // Solo para pruebas, en producción no lo envíes
            'tipo' => $usuario ? 'usuario' : 'profesional'
        ]);
    }

    public function validarCodigo(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'codigo' => 'required',
            'token' => 'required',
        ]);

        $datos = Cache::get('recuperacion_' . $request->email);

        if (!$datos || $datos['token'] !== $request->token || $datos['codigo'] != $request->codigo) {
            return response()->json(['success' => false, 'message' => 'Código inválido o expirado'], 422);
        }

        return response()->json(['success' => true, 'token' => $request->token]);
    }

    public function cambiarContrasena(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'nueva_contrasena' => 'required|min:8',
            'token' => 'required',
        ]);

        $datos = Cache::get('recuperacion_' . $request->email);

        if (!$datos || $datos['token'] !== $request->token) {
            return response()->json(['success' => false, 'message' => 'Token inválido o expirado'], 422);
        }

        $usuario = User::where('email', $request->email)->first();
        $usuario->password = Hash::make($request->nueva_contrasena);
        $usuario->save();

        Cache::forget('recuperacion_' . $request->email);

        return response()->json(['success' => true]);
    }
}
