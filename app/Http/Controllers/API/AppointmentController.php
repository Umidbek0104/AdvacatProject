<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Appointment::all(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'expert_id' => 'required|exists:experts,id',
            'date' => 'required|date',
        ]);

        $appointment = Appointment::create($request->all());

        return response()->json($appointment, 201);
    }

    public function show($id): JsonResponse
    {
        return response()->json(Appointment::findOrFail($id), 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());

        return response()->json($appointment, 200);
    }

    public function destroy($id): JsonResponse
    {
        Appointment::destroy($id);
        return response()->json(null, 204);
    }
}
