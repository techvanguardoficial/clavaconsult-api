<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UpdatePasswordController extends Controller
{
    /**
     * @param Request $request
     * @param string $userId
     * @return Response
     */
    public function update(Request $request, string $userId): Response
    {
        $input = $request->validate([
            'type' => ['required', 'string'],
            'password' => ['required', 'string']
        ]);

        switch ($input['type']) {
            case 'doctor':
                $doctor = Doctor::findOrFail($userId);

                $user = $doctor->user;
                $user->password = $input['password'];
                $user->save();
                break;
            case 'employee':
                $employee = Employee::findOrFail($userId);

                $user = $employee->user;
                $user->password = $input['password'];
                $user->save();
                break;
        }

        $user = null;

        return response()->noContent();
    }
}
