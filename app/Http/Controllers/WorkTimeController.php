<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\WorkTime;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WorkTimeController extends Controller
{
    public function index(Doctor $doctor): JsonResponse
    {
        return response()->json($doctor->workTimes()->orderBy('day_of_week')->orderBy('period')->get());
    }

    public function store(Request $request, Doctor $doctor): JsonResponse
    {
        $input = $request->validate([
            'day_of_week' => ['required', 'integer', 'min:0', 'max:6'],
            'period'      => ['required', 'in:Manhã,Tarde'],
            'start_time'  => ['required', 'date_format:H:i'],
            'end_time'    => ['required', 'date_format:H:i', 'after:start_time'],
            'room' => ['nullable', 'string', 'max:255'],
            'observations' => ['nullable', 'string'],
        ]);

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
            'day_of_week' => ['sometimes', 'integer', 'min:0', 'max:6'],
            'period'      => ['sometimes', 'in:Manhã,Tarde'],
            'start_time'  => ['sometimes', 'date_format:H:i'],
            'end_time'    => ['sometimes', 'date_format:H:i', 'after:start_time'],
            'room' => ['sometimes', 'string', 'max:255'],
            'observations' => ['sometimes', 'string'],
        ]);

        $workTime->update($input);

        return response()->json($workTime);
    }

    public function destroy(Doctor $doctor, WorkTime $workTime): Response
    {
        $workTime->delete();

        return response()->noContent();
    }
}
