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
        // User bilan birga yuklaymiz
        $clients = Client::with('user')->get();

        // Formatlangan natija
        $formatted = $clients->map(function ($client) {
            return [
                'id' => $client->id,
                'user_id' => $client->user_id,
                'name' => $client->user->name ?? null,
                'phone' => $client->user->phone ?? null,
                'email' => $client->user->email ?? null,
                'created_at' => optional($client->created_at)->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formatted,
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $client = Client::create($request->all());

        $client->load('user');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $client->id,
                'user_id' => $client->user_id,
                'name' => $client->user->name ?? null,
                'phone' => $client->user->phone ?? null,
                'email' => $client->user->email ?? null,
            ],
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $client = Client::with('user')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $client->id,
                'user_id' => $client->user_id,
                'name' => $client->user->name ?? null,
                'phone' => $client->user->phone ?? null,
                'email' => $client->user->email ?? null,
            ],
        ], 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $client = Client::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $client->update($validated);
        $client->load('user');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $client->id,
                'user_id' => $client->user_id,
                'name' => $client->user->name ?? null,
                'phone' => $client->user->phone ?? null,
                'email' => $client->user->email ?? null,
            ],
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        Client::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Client successfully deleted',
            'id' => $id,
        ], 204);
    }
}
