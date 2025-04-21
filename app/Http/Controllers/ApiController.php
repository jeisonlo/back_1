<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function testInicial()
    {
        return response()->json(['mensaje' => 'Datos del Test Inicial', 'data' => []]);
    }

    public function inicio()
    {
        return response()->json(['mensaje' => 'Contenido de la página de inicio', 'data' => []]);
    }

    public function informacionFrutas()
    {
        return response()->json(['mensaje' => 'Información de frutas', 'data' => []]);
    }

    public function seguimientoProceso()
    {
        return response()->json(['mensaje' => 'Seguimiento del proceso', 'data' => []]);
    }

    public function foro()
    {
        return response()->json(['mensaje' => 'Datos del foro', 'data' => []]);
    }
}