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
        return response()->json($client, 201);
    }

    public function show($id): JsonResponse
    {
        return response()->json(Client::findOrFail($id), 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $client = Client::findOrFail($id);
        $client->update($request->all());

        return response()->json($client, 200);
    }

    public function destroy($id): JsonResponse
    {
        Client::destroy($id);
        return response()->json(null, 204);
    }
}
