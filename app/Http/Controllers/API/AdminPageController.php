<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AdminPageController extends Controller
{
    public function dashboard(): JsonResponse
    {
        $advocates = User::where('role', 'advocate')->get();
        $categories = Role::all();
        $comments = Review::latest()->take(10)->get();

        return response()->json([
            'status' => true,
            'data' => [
                'advocates' => $advocates,
                'categories' => $this->getCategories(),
                'comments' => $this->getComments(),
                'location' => config('app.location'),
                'info' => [
                    'name' => config('app.name'),
                    'icon' => config('app.icon'),
                    'email' => config('mail.from.address'),
                    'phone' => config('app.phone'),
                    'social' => [
                        'facebook' => config('app.facebook'),
                        'telegram' => config('app.telegram'),
                    ]
                ]
            ]
        ]);
    }

}
