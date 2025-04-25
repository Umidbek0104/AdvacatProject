<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Expert;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpertController extends Controller
{
    public function index(): JsonResponse
    {
        $perPage = 1;

        // User va Role ma’lumotlarini birga yuklaydi
        $experts = Expert::with(['user.role'])->paginate($perPage);

        // Ma’lumotlarni kerakli formatga o‘zgartiramiz
        $formattedData = $experts->items(); // paginate'dan to‘g‘ridan-to‘g‘ri itemlar

        $formattedData = array_map(function ($expert) {
            return [
                'id' => $expert->id,  // Add ID to the response
                'name' => $expert->user->name ?? null,
                'role' => $expert->user->role->name ?? null,
                'specialization' => $expert->specialization,
                'experience' => $expert->experience,
                'rating' => $expert->rating,
                'bio' => $expert->bio,
                'created_at' => optional($expert->created_at)->format('Y-m-d H:i:s'),
            ];
        }, $formattedData);

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

//        dd($request);
        $request->validate([
            'user_id' => 'required|exists:users,id',
//            'role_id' => 'required|exists:roles,id', // `role_id` ni validate qilish
        ]);


        // Foydalanuvchini bazadan olib kelamiz
        $user = User::find($request->user_id);

        // 1. Role_id tekshiriladi (faqat 2 yoki 3 bo‘lsa davom etadi)
        if (!in_array($request->role_id, [2, 3])) {
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
        $expert = Expert::with('user.role')->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $expert->id,
                'user_id' => $expert->user_id,
                'specialization' => $expert->specialization,
                'experience' => $expert->experience,
                'rating' => $expert->rating,
                'bio' => $expert->bio,
//                'litsensiya_id' => $expert->litsensiya_id,
//                'role_id' => $expert->role_id, // role_id ni qo'shish
            ]
        ], 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        // Validatsiya

//        dd($request->all());
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
//            'role_id' => 'required|exists:roles,id', // `role_id`ni tekshirish
            'specialization' => 'nullable|exists:specializations,id',
            'experience' => 'required|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'bio' => 'nullable|string',
//            'litsensiya_id' => 'nullable|exists:litsensiyas,id',
        ]);
        // Expertni topamiz
        $expert = Expert::findOrFail($id);

        // Yangilash
        $expert->update($validated);

        // To‘liq ma’lumotlarni yuklaymiz (agar user bilan bog‘liq bo‘lsa)
        $expert->load('user.role');

        // Javobga expertning barcha ustunlarini yuboramiz
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $expert->id,
                'user_id' => $expert->user_id,
                'specialization' => $expert->specialization,
                'experience' => $expert->experience,
                'rating' => $expert->rating,
                'bio' => $expert->bio,
//                'litsensiya_id' => $expert->litsensiya_id,
//                'role_id' => $expert->role_id, // `role_id` ni qo'shish
            ]
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        Expert::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Expert muvaffaqiyatli o‘chirildi',
            'id' => $id
        ], 204);
    }
}
