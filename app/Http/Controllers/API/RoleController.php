<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Role::all(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        $role = Role::create($request->all());
        return response()->json($role, 201);
    }

    public function show($id): JsonResponse
    {
        return response()->json(Role::findOrFail($id), 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $role = Role::findOrFail($id);
        $role->update($request->all());

        return response()->json($role, 200);
    }

    public function destroy($id): JsonResponse
    {
        Role::destroy($id);
        return response()->json(null, 204);
    }
}
