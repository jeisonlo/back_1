<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\enotification;
use Illuminate\Http\Request;

class EnotificationController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'descripcion' => 'required|max:555'

        ]);

        $Notificacion = enotification::create($request->all());

        return response()->json($Notificacion);
    }



public function index(){
    $Notificacion=enotification::all();
    
    return response()->json($Notificacion);
}





public function show($id){
    $Notificacion = enotification::findOrFail($id);
    return response()->json($Notificacion);
}





public function update(Request $request, enotification $Notificacion)
    {
        $request->validate([
            'descripcion' => 'required|max:255' .$Notificacion->id,

        ]);

        $Notificacion->update($request->all());

        return response()->json($Notificacion);
    }


    
    public function destroy(enotification $Notificacion)
    {
        $Notificacion->delete();
        return response()->json($Notificacion);
    }

}

