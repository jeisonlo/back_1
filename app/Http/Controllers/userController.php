<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);
    
    // Validación básica - ajusta según tus necesidades
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'especialidad' => 'nullable|string' // solo para profesionales
    ]);

    $user->update($validated);

    return response()->json($user);
}
    public function show()
{
    $user = Auth::user();
    return view('usuario', compact('user'));
}
public function showProfile()
{
    $user = Auth::user(); // Obtiene el usuario autenticado
    return view('usuario', ['user' => $user]);
}
}