<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Event;
use App\Models\MedicalReport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MedicalReportController extends Controller
{
    public function store(Request $request): array
    {
        $input = $request->validate([
            'doctor_id' => ['required', 'numeric', 'integer', 'exists:doctors,id'],
            'patient_id' => ['required', 'numeric', 'integer', 'exists:patients,id']
        ]);

        $appointmentQuery = Appointment::query();
        $appointmentQuery->whereHas('event', function (Builder $query) use ($request) {
            $query->where('doctor_id', $request->input('doctor_id'));
            $query->where('date', (now())->toDateString());
        });

        $appointmentQuery->where('patient_id', $request->input('patient_id'));
        $appointmentQuery->where('status', 1);

        $appointment = $appointmentQuery->first();

        if ($appointment) {
            return [
                'appointment_id' => $appointment->id
            ];
        }

        // Cria appointment (agendamento)
        $appointment = new Appointment([
            'patient_id' => $input['patient_id'],
            'plan_id' => 17, // Referência ao convênio nomeado como "Não informado"
            'type' => 'default',
            'comment' => '',
            'status' => 1
        ]);

        $appointment->save();

        // Cria evento (event)
        $event = new Event([
            'date' => (now())->tz('America/Sao_Paulo')->toDateString(),
            'time' => (now())->tz('America/Sao_Paulo')->toTimeString(),
            'duration' => '00:20:00',
            'doctor_id' => $input['doctor_id']
        ]);

        $appointment->event()->save($event);

        return [
            'appointment_id' => $appointment->id
        ];
    }
}
