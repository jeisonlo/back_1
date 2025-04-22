<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index()
    {
        {
            return response()->json(Tarjeta::all());
        }



        /*
        $tarjetas = [
            [
                'id' => 1,
                'title' => 'Información Frutas',
                'image' => 'inclued/FrutasInf.jpg',
                'description' => 'Los usuarios podrán identificar cómo ciertos alimentos influyen en su estado de ánimo...',
                'url' => '../InformacionFrutas/frutas.html'
            ],

            [
                'id' => 2,
                'title' => 'Seguimiento de Proceso',
                'image' => 'inclued/SEGUIMIENTO copy.png',
                'description' => 'El seguimiento de proceso permitirá rastrear y monitorear el progreso del usuario...',
                'url' => '../SEGUIMINETODEPROCESO_3/Seguimiento.html'
            ],

            [
                'id' => 3,
                'title' => 'Foro',
                'image' => 'inclued/social_media.jpg',
                'description' => 'Recurso bienestar es una plataforma donde se almacenará y organizará información...',
                'url' => '../Foro/foro.html'
            ]
        ];

        return response()->json($tarjetas);
     */   

    }
}
