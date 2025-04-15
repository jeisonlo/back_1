<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Método para crear un nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);

        $user = User::create($request->all());

        return response()->json($user);
    }

    // Método para obtener todos los usuarios
    public function index()
    {
        $user = User::included()->get();
        return response()->json($user);
    }

    // Método para obtener un solo usuario por su ID
    public function show($id)
    {
        $user = User::included()->findOrFail($id);
        return response()->json($user);
    }

    // Método para actualizar un usuario
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|max:255', // Validación básica, puedes agregar más reglas
        ]);

        $user->update($request->all());

        return response()->json($user);
    }

    // Método para eliminar un usuario
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json($user);
    }

    // Método para actualizar la información de un usuario por ID
    public function updateById(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validación avanzada para actualización
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'especialidad' => 'nullable|string' // solo para profesionales
        ]);

        $user->update($validated);

        return response()->json($user);
    }

    // Método para mostrar el perfil del usuario autenticado
    public function showProfile()
    {
        $user = Auth::user(); // Obtiene el usuario autenticado
        return view('usuario', ['user' => $user]);
    }

    // Método para mostrar un único usuario autenticado
    public function showAuthenticatedUser()
    {
        $user = Auth::user();
        return view('usuario', compact('user'));
    }
}
