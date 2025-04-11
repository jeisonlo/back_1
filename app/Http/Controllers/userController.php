<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\user;
use Illuminate\Http\Request;

class userController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255'

        ]);

        $user = user::create($request->all());

        return response()->json($user);
    }

public function index(){
    //$user=User::all();
   
    $user=User::included()->get();
   
    return response()->json($user);
}



public function show($id){
    //$user = user::findOrFail($id);
    $user = user::included()->findOrFail($id);
    return response()->json($user);
}

public function update(Request $request, user $user)
    {
        $request->validate([
            'name' => 'required|max:255' .$user->id,

        ]);

        $user->update($request->all());

        return response()->json($user);
    }
    public function destroy(user $user)
    {
        $user->delete();
        return response()->json($user);
    }

}

