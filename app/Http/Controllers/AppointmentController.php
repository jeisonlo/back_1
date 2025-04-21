<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::all();
        return response()->json(['data' => $appointments], 200);
    }
    // Para la vista (devuelve HTML)
    /**
     * Muestra el formulario para crear una nueva cita (opcional para APIs).
     */
    public function create()
    {
        return view('appointments.create'); // Si usas vistas
    }

    /**
     * Almacena una nueva cita en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
            'paquete' => 'required|string|max:255',
            'especialidad' => 'required|string|max:255',
            'profesional' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'comentarios' => 'nullable|string',
        ]);

        // Si la validación falla, retornar errores
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Crear la cita en la base de datos
        $appointment = Appointment::create($request->all());

        // Retornar una respuesta JSON
        return response()->json([
            'message' => 'Cita agendada con éxito',
            'data' => $appointment,
        ], 201);
    }

    /**
     * Muestra los detalles de una cita específica.
     */
    public function show($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        return response()->json(['data' => $appointment], 200);
    }

    /**
     * Muestra el formulario para editar una cita (opcional para APIs).
     */
    public function edit($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        return view('appointments.edit', compact('appointment')); // Si usas vistas
    }

    /**
     * Actualiza una cita en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Buscar la cita por ID
        $appointment = Appointment::find($id);

        // Si la cita no existe, retornar un error 404
        if (!$appointment) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        // Validar solo los campos que se van a actualizar
        $validator = Validator::make($request->all(), [
            'fecha' => 'sometimes|date', // Solo fecha
            'hora' => 'sometimes|date_format:H:i', // Solo hora
            'comentarios' => 'nullable|string', // Solo comentarios
        ]);

        // Si la validación falla, retornar errores
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Actualizar solo los campos permitidos
        $appointment->update([
            'fecha' => $request->input('fecha', $appointment->fecha), // Mantener el valor actual si no se proporciona
            'hora' => $request->input('hora', $appointment->hora), // Mantener el valor actual si no se proporciona
            'comentarios' => $request->input('comentarios', $appointment->comentarios), // Mantener el valor actual si no se proporciona
        ]);

        // Retornar una respuesta exitosa
        return response()->json([
            'message' => 'Cita actualizada con éxito',
            'data' => $appointment,
        ], 200);
    }

    /**
     * Elimina una cita de la base de datos.
     */
    public function destroy($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $appointment->delete();

        return response()->json(['message' => 'Cita eliminada con éxito'], 200);
    }
}
