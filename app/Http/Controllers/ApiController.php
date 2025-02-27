<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => '¡API en Laravel 10 funcionando!'
        ]);
    }
}
