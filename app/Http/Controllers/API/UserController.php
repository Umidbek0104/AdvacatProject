<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Foydalanuvchi profilingini to'ldirib, admin tasdiqlashiga yuboradi.
     */
    public function submitProfile(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'required|string|max:20|unique:users,phone,' . auth()->id(),
            'specialization' => 'required|string|max:255',
            'experience' => 'required|integer|min:0',
            'license_number' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->specialization = $request->specialization;
        $user->experience = $request->experience;
        $user->license_number = $request->license_number;
        $user->status = 'pending'; // Admin tasdiqlashini kutadi
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile submitted for approval',
            'data' => $user
        ]);
    }
    public function store(Request $request)
    {
        return response()->json(['message' => 'Profile submitted successfully!']);
    }
}
