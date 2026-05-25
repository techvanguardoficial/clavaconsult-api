<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Plan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DoctorPlanController extends Controller
{
    public function index(Doctor $doctor): JsonResponse
    {
        return response()->json($doctor->plans()->withPivot('consultation_value')->get());
    }

    public function store(Request $request, Doctor $doctor): JsonResponse
    {
        $input = $request->validate([
            'plan_id'            => ['required', 'exists:plans,id'],
            'consultation_value' => ['nullable', 'numeric', 'min:0'],
        ]);

        $doctor->plans()->syncWithoutDetaching([
            $input['plan_id'] => ['consultation_value' => $input['consultation_value'] ?? null],
        ]);

        return response()->json($doctor->plans()->withPivot('consultation_value')->get());
    }

    public function update(Request $request, Doctor $doctor, Plan $plan): JsonResponse
    {
        $input = $request->validate([
            'consultation_value' => ['nullable', 'numeric', 'min:0'],
        ]);

        $doctor->plans()->updateExistingPivot($plan->id, [
            'consultation_value' => $input['consultation_value'],
        ]);

        return response()->json($doctor->plans()->withPivot('consultation_value')->get());
    }

    public function destroy(Doctor $doctor, Plan $plan): Response
    {
        $doctor->plans()->detach($plan->id);

        return response()->noContent();
    }
}
