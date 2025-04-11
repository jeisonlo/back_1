<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Estiramiento;
use App\Models\stretch;
use Illuminate\Http\Request;

class StretchController extends Controller
{
    public function index(){
        $user=stretch::all();
        return response()->json($user);
    }
}
