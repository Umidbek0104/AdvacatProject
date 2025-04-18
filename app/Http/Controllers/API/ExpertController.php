<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Expert;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpertController extends Controller
{
    public function index(): JsonResponse
    {
        $perPage = 15;
        $experts = Expert::with('user')->paginate($perPage);

        $formattedData = $experts->map(function ($expert) {
            return [
                'name' => $expert->user->name ?? null,
                'role' => $expert->user->role->name ?? null,
                'specialization' => $expert->specialization,
                'experience' => $expert->experience,
                'rating' => $expert->rating,
                'bio' => $expert->bio,
                'created_at' => $expert->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Foydalanuvchilar muvaffaqiyatli olindi',
            'data' => $formattedData,
            'page' => $experts->currentPage(),
            'per_page' => $experts->perPage(),
            'total' => $experts->total(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Foydalanuvchini bazadan olib kelamiz
        $user = User::find($request->user_id);

        // 1. Role_id tekshiriladi (faqat 2 yoki 3 bo‘lsa davom etadi)
        if (!in_array($user->role_id, [2, 3])) {
            return response()->json(['error' => 'Foydalanuvchi advokat yoki notarius emas'], 403);
        }

        // 2. Oldin shu user_id bilan Expert mavjud emasligini tekshiramiz
        $existing = Expert::where('user_id', $user->id)->first();
        if ($existing) {
            return response()->json(['error' => 'Bu foydalanuvchi allaqachon Expert ro‘yxatida mavjud'], 409);
        }

        // 3. Expert yaratish
        $expert = Expert::create($request->all());

        return response()->json(['success' => true, 'data' => $expert], 201);
    }

    public function show($id): JsonResponse
    {
        return response()->json(Expert::findOrFail($id), 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $expert = Expert::findOrFail($id);
        $expert->update($request->all());

        return response()->json($expert, 200);
    }

    public function destroy($id): JsonResponse
    {
        Expert::destroy($id);
        return response()->json(null, 204);
    }


}
