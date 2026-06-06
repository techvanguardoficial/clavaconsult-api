<?php

namespace App\Http\Controllers;

use App\Models\AppointmentLog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

class AppointmentLogController extends Controller
{
    public static function log(int $appointmentId, string $actionType, int $userId): void
    {
        AppointmentLog::create([
            'user_id'        => auth()->id() ?? $userId, // Usa o ID do usuário autenticado ou o fornecido como fallback
            'appointment_id' => $appointmentId,
            'action_type'    => $actionType,
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $query = AppointmentLog::with('user')
            ->when($request->query('user_id'), fn($q, $userId) => $q->where('user_id', $userId))
            ->when($request->query('action_type'), fn($q, $type) => $q->where('action_type', $type))
            ->orderBy('created_at', 'DESC');

        return response()->json($query->cursorPaginate(25)->withQueryString());
    }
}
