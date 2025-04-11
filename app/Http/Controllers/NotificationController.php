<?php

namespace App\Http\Controllers;

use App\Models\notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'message' => 'required|string',
        ]);
    
        $notification = notification::create([
            'message' => $request->message,
            'time' => Carbon::now()->format('h:i A') // Hora actual en formato 12h (ej: 07:14 AM)
        ]);
    
        return response()->json($notification, 201);
    }
    public function index()
{
    return response()->json(Notification::all(), 200);
}
}
