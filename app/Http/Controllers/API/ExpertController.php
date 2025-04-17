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
        $experts =User::all();
        $guards=[
            'advacat'=>$experts->where('role','advacat'),
            'natarius'=>$experts->where('role','natarius'),
        ];
        return response()->json($guards);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
//        $expert = Expert::create($request->all());
//        return response()->json(['success' => true, 'data' => $expert], 201);
        $expert = Expert::create($request->all());
        return response()->json($expert, 201);
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
