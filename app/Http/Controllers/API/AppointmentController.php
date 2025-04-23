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
        $perPage = 15;

        // Ehtimoliy bog‘liqliklar bo‘lsa, with() orqali yuklab olish mumkin
        $appointments = Appointment::with(['user', 'expert.user']) // agar bog'langan bo'lsa
        ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $formattedData = $appointments->map(function ($appointment) {
            return [
                'id' => $appointment->id,
                'user_name' => $appointment->user->name ?? null,
                'expert_name' => $appointment->expert->user->name ?? null,
                'date' => $appointment->date ?? null,
                'time' => $appointment->time ?? null,
                'status' => $appointment->status ?? 'pending', // status maydoni mavjud bo‘lsa
                'created_at' => optional($appointment->created_at)->format('Y-m-d H:i:s'),
            ];
        })->values();

        return response()->json([
            'success' => true,
            'message' => 'Uchrashuvlar muvaffaqiyatli olindi',
            'data' => $formattedData,
            'page' => $appointments->currentPage(),
            'per_page' => $appointments->perPage(),
            'total' => $appointments->total(),
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            // 1. Ma'lumotlarni tekshirish
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'expert_id' => 'required|exists:experts,id',
                'date'      => 'required|date',
                'time'      => 'nullable|date_format:H:i:s',
                'status'    => 'nullable|string',
            ]);

            // 2. Appointmentni yaratish
            $appointment = Appointment::create($validatedData);

            // 3. JSON responsni yuborish
            return response()->json([
                'success' => true,
                'message' => 'Appointment created successfully.',
                'submitted_data' => $validatedData,
                'created_appointment' => $appointment,
            ], 201); // 201 - Created

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validatsiya xatoliklari mavjud.',
                'errors' => $e->errors(),
            ], 422); // 422 - Unprocessable Entity
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server xatosi: ' . $e->getMessage(),
            ], 500);
        }
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
