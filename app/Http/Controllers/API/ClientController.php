<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Client::all(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $client = Client::create($request->all());
        return response()->json([
            'success' => true,
            'data' => $client,
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $client = Client::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $client,
            'id' => $id,  // IDni qo'shish
        ], 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $client = Client::findOrFail($id);

        // Validatsiya (agarda zarur bo'lsa)
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $client->update($validated);

        return response()->json([
            'success' => true,
            'data' => $client,
            'id' => $id,  // IDni qo'shish
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        Client::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Client successfully deleted',
            'id' => $id,  // IDni qo'shish
        ], 204);
    }
}
