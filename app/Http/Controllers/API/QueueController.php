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
        $queues = Queue::with(['expert.user', 'client.user'])->get();

        $data = $queues->map(function ($queue) {
            return [
                'id' => $queue->id,
                'status' => $queue->status,
                'position' => $queue->position,
                'expert_name' => $queue->expert->user->name ?? null,
                'client_name' => $queue->client->user->name ?? null,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Navbatlar muvaffaqiyatli olindi',
            'data' => $data
        ], 200);
    }
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'expert_id' => 'required|exists:experts,id',
            'status' => 'required|string',
        ]);

        $queue = Queue::create($request->only(['client_id', 'expert_id', 'status']));
        $queue->load(['expert.user', 'client.user']);

        return response()->json([
            'success' => true,
            'message' => 'Yangi navbat yaratildi',
            'data' => [
                'id' => $queue->id,
                'status' => $queue->status,
                'client_name' => $queue->client->user->name ?? null,
                'expert_name' => $queue->expert->user->name ?? null,
            ]
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $queue = Queue::with(['expert.user', 'client.user'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Navbat topildi',
            'data' => [
                'id' => $queue->id,
                'status' => $queue->status,
                'client_name' => $queue->client->user->name ?? null,
                'expert_name' => $queue->expert->user->name ?? null,
            ]
        ], 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'expert_id' => 'required|exists:experts,id',
            'status' => 'required|string',
        ]);

        $queue = Queue::findOrFail($id);
        $queue->update($request->only(['client_id', 'expert_id', 'status']));
        $queue->load(['expert.user', 'client.user']);

        return response()->json([
            'success' => true,
            'message' => 'Navbat maʼlumotlari yangilandi',
            'data' => [
                'id' => $queue->id,
                'status' => $queue->status,
                'client_name' => $queue->client->user->name ?? null,
                'expert_name' => $queue->expert->user->name ?? null,
            ]
        ], 200);
    }


    public function destroy($id): JsonResponse
    {
        $queue = Queue::findOrFail($id);
        $queue->delete();

        return response()->json([
            'success' => true,
            'message' => 'Navbat muvaffaqiyatli o‘chirildi'
        ], 200);
    }
}
