<?php

namespace App\Http\Controllers;

use App\Models\informacionFruta;
use Illuminate\Http\Request;

class InformacionFrutaController extends Controller
{
    public function index(Request $request)
    {
        $query = informacionFruta::query();
        
        if ($request->has('search')) {
            $query->where('fruta', 'like', '%'.$request->search.'%');
        }

        return $query->get();
    }

    public function show($id)
    {
        return informacionFruta::findOrFail($id);
    }
}