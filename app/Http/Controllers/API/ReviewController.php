<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Review::all(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'expert_id' => 'required|exists:experts,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $review = Review::create($request->all());
        return response()->json($review, 201);
    }

    public function show($id): JsonResponse
    {
        return response()->json(Review::findOrFail($id), 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $review = Review::findOrFail($id);
        $review->update($request->all());

        return response()->json($review, 200);
    }

    public function destroy($id): JsonResponse
    {
        Review::destroy($id);
        return response()->json(null, 204);
    }
}
