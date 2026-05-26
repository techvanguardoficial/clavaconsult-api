<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\WorkTime;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class WorkTimeController extends Controller
{
    public function index(Doctor $doctor): JsonResponse
    {
        return response()->json($doctor->workTimes()->with('unitRoom')->orderBy('day_of_week')->orderBy('period')->get());
    }

    public function store(Request $request, Doctor $doctor): JsonResponse
    {
        $input = $request->validate([
            'day_of_week'  => ['required', 'integer', 'min:0', 'max:6'],
            'period'       => ['required', 'in:Manhã,Tarde'],
            'start_time'   => ['required', 'date_format:H:i'],
            'end_time'     => ['required', 'date_format:H:i', 'after:start_time'],
            'unit_room_id' => ['nullable', 'exists:unit_rooms,id'],
            'observations' => ['nullable', 'string'],
        ]);

        $this->validateRoomConflict($input['unit_room_id'] ?? null, $input['day_of_week'], $input['period']);

        try {
            $workTime = $doctor->workTimes()->create($input);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                return response()->json([
                    'message' => 'Já existe um horário cadastrado para este médico neste dia e período.',
                ], 422);
            }

            throw $e;
        }

        return response()->json($workTime, 201);
    }

    public function update(Request $request, Doctor $doctor, WorkTime $workTime): JsonResponse
    {
        $input = $request->validate([
            'day_of_week'  => ['sometimes', 'integer', 'min:0', 'max:6'],
            'period'       => ['sometimes', 'in:Manhã,Tarde'],
            'start_time'   => ['sometimes', 'date_format:H:i'],
            'end_time'     => ['sometimes', 'date_format:H:i', 'after:start_time'],
            'unit_room_id' => ['sometimes', 'nullable', 'exists:unit_rooms,id'],
            'observations' => ['sometimes', 'string'],
        ]);

        $roomId     = $input['unit_room_id'] ?? $workTime->unit_room_id;
        $dayOfWeek  = $input['day_of_week'] ?? $workTime->day_of_week;
        $period     = $input['period'] ?? $workTime->period;

        $this->validateRoomConflict($roomId, $dayOfWeek, $period, $workTime->id);

        $workTime->update($input);

        return response()->json($workTime);
    }

    public function destroy(Doctor $doctor, WorkTime $workTime): Response
    {
        $workTime->delete();

        return response()->noContent();
    }

    private function validateRoomConflict(?int $unitRoomId, int $dayOfWeek, string $period, ?int $ignoreId = null): void
    {
        if (!$unitRoomId) {
            return;
        }

        $exists = WorkTime::where('unit_room_id', $unitRoomId)
            ->where('day_of_week', $dayOfWeek)
            ->where('period', $period)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'unit_room_id' => 'Esta sala já está ocupada neste dia e período por outro médico.',
            ]);
        }
    }
}
