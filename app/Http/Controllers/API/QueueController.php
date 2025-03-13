<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Queue::all(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'expert_id' => 'required|exists:experts,id',
            'status' => 'required|string',
        ]);

        $queue = Queue::create($request->all());
        return response()->json($queue, 201);
    }

    public function show($id): JsonResponse
    {
        return response()->json(Queue::findOrFail($id), 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $queue = Queue::findOrFail($id);
        $queue->update($request->all());

        return response()->json($queue, 200);
    }

    public function destroy($id): JsonResponse
    {
        Queue::destroy($id);
        return response()->json(null, 204);
    }
}
