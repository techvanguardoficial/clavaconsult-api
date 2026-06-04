<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use App\Models\CsatBotResponse;
use App\Models\CsatDoctorResponse;
use App\Models\CsatReceptionistResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CsatController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'patient_id'                  => 'required|exists:patients,id',
            'appointment_id'              => 'nullable|exists:appointments,id',
            'doctor'                      => 'nullable|array',
            'doctor.doctor_id'            => 'required_with:doctor|exists:doctors,id',
            'doctor.score'                => 'required_with:doctor|integer|min:1|max:5',
            'doctor.comment'              => 'nullable|string',
            'receptionist'                => 'nullable|array',
            'receptionist.employee_id'    => 'nullable|exists:employees,id',
            'receptionist.score'          => 'required_with:receptionist|integer|min:1|max:5',
            'receptionist.comment'        => 'nullable|string',
            'bot'                         => 'nullable|array',
            'bot.score'                   => 'required_with:bot|integer|min:1|max:5',
            'bot.comment'                 => 'nullable|string',
        ]);

        DB::transaction(function () use ($data) {
            $base = [
                'patient_id'     => $data['patient_id'],
                'appointment_id' => $data['appointment_id'] ?? null,
                'responded_at'   => now(),
            ];

            if (!empty($data['doctor'])) {
                CsatDoctorResponse::create(array_merge($base, [
                    'doctor_id' => $data['doctor']['doctor_id'],
                    'score'     => $data['doctor']['score'],
                    'comment'   => $data['doctor']['comment'] ?? null,
                    'source'    => 'bot',
                ]));
            }

            if (!empty($data['receptionist'])) {
                CsatReceptionistResponse::create(array_merge($base, [
                    'employee_id' => $data['receptionist']['employee_id'] ?? null,
                    'score'       => $data['receptionist']['score'],
                    'comment'     => $data['receptionist']['comment'] ?? null,
                    'source'      => 'bot',
                ]));
            }

            if (!empty($data['bot'])) {
                CsatBotResponse::create(array_merge($base, [
                    'score'   => $data['bot']['score'],
                    'comment' => $data['bot']['comment'] ?? null,
                ]));
            }
        });

        return response()->json(['message' => 'Avaliação registrada com sucesso.'], 201);
    }
}
