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
        // Queue bilan bog'langan Expert va Clientni yuklash
        $queues = Queue::with(['expert', 'client'])->get();

        // Natijani formatlash
        $data = $queues->map(function($queue) {
            return [
                'id' => $queue->id, // Queue ID
                'status' => $queue->status, // Queue holati
                'position' => $queue->position, // Pozitsiya
                'expert_name' => $queue->expert->user->name, // Expertning ismi
                'client_name' => $queue->client->user->name, // Clientning ismi
            ];
        });

        return response()->json($data, 200);
    }
    public function store(Request $request): JsonResponse
    {
        // So'rovni validatsiya qilish
        $request->validate([
            'client_id' => 'required|exists:clients,id',  // client_id must exist in the clients table
            'expert_id' => 'required|exists:experts,id',  // expert_id must exist in the experts table
            'status' => 'required|string',
        ]);

        // Yangi Queue yaratish
        $queue = Queue::create([
            'client_id' => $request->client_id,
            'expert_id' => $request->expert_id,
            'status' => $request->status,
        ]);

        // Queue bilan bog'langan Expert va Clientni yuklash
        $queue->load(['expert', 'client']);

        // Natijani formatlash
        return response()->json([
            'id' => $queue->id,
            'status' => $queue->status,
            'client_name' => $queue->client->user->name,
            'expert_name' => $queue->expert->user->name,
        ], 201);
    }

    public function show($id): JsonResponse
    {
        // Queue bilan bog'langan Expert va Clientni yuklash
        $queue = Queue::with(['expert', 'client'])->findOrFail($id);

        // Natijani formatlash
        return response()->json([
            'id' => $queue->id,
            'status' => $queue->status,
            'client_name' => $queue->client->user->name,
            'expert_name' => $queue->expert->user->name,
        ], 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        // So'rovni validatsiya qilish
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'expert_id' => 'required|exists:experts,id',
            'status' => 'required|string',
        ]);

        // Queue-ni topish
        $queue = Queue::findOrFail($id);

        // Queue-ni yangilash
        $queue->update([
            'client_id' => $request->client_id,
            'expert_id' => $request->expert_id,
            'status' => $request->status,
        ]);

        // Queue bilan bog'langan Expert va Clientni yuklash
        $queue->load(['expert', 'client']);

        // Natijani formatlash
        return response()->json([
            'id' => $queue->id,
            'status' => $queue->status,
            'client_name' => $queue->client->user->name,
            'expert_name' => $queue->expert->user->name,
        ], 200);
    }


    public function destroy($id): JsonResponse
    {
        // Queue-ni topib o'chirish
        $queue = Queue::findOrFail($id);
        $queue->delete();

        // Javob qaytarish
        return response()->json(null, 204);  // 204 - No Content (successfully deleted)
    }
}
