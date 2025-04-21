<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index()
    {
        // Si Review tiene relación con User o Professional, puedes usar ->with(['user', 'professional'])
        return response()->json(Review::all(), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $review = Review::create($request->all());
            return response()->json($review, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al guardar la reseña'], 500);
        }
    }

    public function show($id)
    {
        $review = Review::find($id);
        
        if (!$review) {
            return response()->json(['error' => 'Reseña no encontrada'], 404);
        }

        return response()->json($review, 200);
    }

    public function update(Request $request, $id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['error' => 'Reseña no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'stars' => 'sometimes|integer|min:1|max:5',
            'comment' => 'sometimes|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $review->update($request->all());
            return response()->json($review, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar la reseña'], 500);
        }
    }

    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['error' => 'Reseña no encontrada'], 404);
        }

        try {
            $review->delete();
            return response()->json(['message' => 'Reseña eliminada correctamente'], 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar la reseña'], 500);
        }
    }
}