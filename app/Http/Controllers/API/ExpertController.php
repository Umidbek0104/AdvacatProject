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
        $users = User::whereIn('role_id', [2, 3])->get();

        return response()->json([
            'data' => $users
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Foydalanuvchini topamiz
        $user = User::find($request->user_id);

        // Faqatgina role_id 2 yoki 3 bo‘lsa, Expert jadvaliga qo‘shamiz
        if (in_array($user->role_id, [2, 3])) {
            $expert = Expert::create($request->all());
            return response()->json(['success' => true, 'data' => $expert], 201);
        } else {
            return response()->json(['error' => 'Foydalanuvchi advokat yoki notarius emas'], 403);
        }
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
