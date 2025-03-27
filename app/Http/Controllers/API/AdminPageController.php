<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AdminPageController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => [
                'advocates' => User::where('role_id', 2)->get(),
                'specializations' => Specialization::all(),
            ]
        ], 200);
    }

    /**
     * Yangi to'ldirilgan profillarni admin oynasiga chiqarish.
     */
    public function pendingProfiles(): JsonResponse
    {
        $users = User::where('status', 'pending')->get();

        return response()->json([
            'status' => true,
            'message' => 'Pending user profiles',
            'data' => $users
        ]);
    }

    /**
     * Admin foydalanuvchini tasdiqlaydi.
     */
    public function approveProfile($id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->status = 'approved';
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User profile approved',
            'data' => $user
        ]);
    }

    /**
     * Admin foydalanuvchini rad etadi.
     */
    public function rejectProfile($id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->status = 'rejected';
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User profile rejected',
            'data' => $user
        ]);
    }

}
