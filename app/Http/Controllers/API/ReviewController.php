<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Review::all(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'expert_id' => 'required|exists:experts,id',
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string',
            ]);

            $review = Review::create($validatedData);

            return response()->json([
                'message' => 'Sharh muvaffaqiyatli qo‘shildi!',
                'data' => $review
            ], 201);

        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Maʼlumotlar bazasi bilan bog‘liq muammo yuz berdi.',
                'details' => $e->getMessage()
            ], 400);

        } catch (\Exception $e) {
            Log::error('Umumiy xatolik: ' . $e->getMessage());
            return response()->json([
                'error' => 'Kutilmagan xatolik yuz berdi.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    public function show($id): JsonResponse
    {
        return response()->json(Review::findOrFail($id), 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            // Validatsiya
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'expert_id' => 'required|exists:experts,id',
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string',
            ]);

            // Reviewni topish
            $review = Review::findOrFail($id);

            // Yangilash
            $review->update($validatedData);

            return response()->json([
                'message' => 'Sharh muvaffaqiyatli yangilandi!',
                'data' => $review
            ], 200);

        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Database error during update: " . $e->getMessage());
            return response()->json([
                'error' => 'Maʼlumotlar bazasida xatolik.',
                'details' => $e->getMessage()
            ], 400);

        } catch (\Exception $e) {
            Log::error("Exception during review update: " . $e->getMessage());
            return response()->json([
                'error' => 'Kutilmagan xatolik yuz berdi.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        Review::destroy($id);
        return response()->json(null, 204);
    }
}
