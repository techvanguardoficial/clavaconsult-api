<?php

namespace App\Http\Controllers;

use App\Events\ScheduleUpdated;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppointmentStatusController extends Controller
{
    /**
     * @param Request $request
     * @param Appointment $appointment
     * @return Response
     */
    public function store(Request $request, Appointment $appointment): Response
    {
        $input = $request->validate([
            'status' => ['required']
        ]);

        $appointment->update($input);

        ScheduleUpdated::dispatch($appointment->event->doctor);

        return response()->noContent();
    }
}
