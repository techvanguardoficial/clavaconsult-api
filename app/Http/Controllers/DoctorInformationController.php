<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorInformation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorInformationController extends Controller
{
    public function index(Doctor $doctor): JsonResponse
    {
        return response()->json($doctor->information);
    }

    public function store(Request $request, Doctor $doctor): JsonResponse
    {
        $data = $request->validate([
            'key'         => 'nullable|string|max:255',
            'information' => 'required|string',
            'active'      => 'boolean',
        ]);

        $info = $doctor->information()->create($data);

        return response()->json($info, 201);
    }

    public function update(Request $request, Doctor $doctor, DoctorInformation $information): JsonResponse
    {
        $data = $request->validate([
            'key'         => 'nullable|string|max:255',
            'information' => 'required|string',
            'active'      => 'boolean',
        ]);

        $information->update($data);

        return response()->json($information);
    }

    public function destroy(Doctor $doctor, DoctorInformation $information): JsonResponse
    {
        $information->delete();

        return response()->json(null, 204);
    }
}
