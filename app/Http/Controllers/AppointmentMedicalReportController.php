<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalReport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppointmentMedicalReportController extends Controller
{
    /**
     * @param Appointment $appointment
     * @return Model|HasOne
     */
    public function show(Appointment $appointment)
    {
        return $appointment->medicalReport()->firstOrFail();
    }

    /**
     * @param Appointment $appointment
     * @param Request $request
     * @return MedicalReport
     */
    public function store(Appointment $appointment, Request $request): MedicalReport
    {
        $input = $request->validate([
            'date' => ['required', 'string', 'date_format:Y-m-d'],
            'time' => ['required', 'string', 'date_format:H:i'],
            'duration' => ['required', 'string', 'date_format:H:i:s'],

            'fields' => ['required', 'array'],
            'fields.*.report_field_id' => ['required', 'numeric', 'integer', 'exists:report_fields,id'],
            'fields.*.value' => ['required', 'string', 'max:1000'],

            'status' => ['required', 'string', 'in:committed']
        ]);

        $appointment->status = 6;
        $appointment->save();

        $report = new MedicalReport($input);
        $appointment->medicalReport()->save($report);

        $report->fieldData()->createMany($input['fields']);

        return $report;
    }

    /**
     * @return void
     */
    public function update(Request $request, Appointment $appointment): Response
    {
        $input = $request->validate([
            'fields' => ['required', 'array'],
            'fields.*.report_field_id' => ['required', 'numeric', 'integer', 'exists:report_fields,id'],
            'fields.*.value' => ['required', 'string', 'max:1000']
        ]);

        $appointment->medicalReport->fieldData()->delete();
        $appointment->medicalReport->fieldData()->createMany($input['fields']);

        return response()->noContent();
    }

    /**
     * @param Appointment $appointment
     * @return Response
     */
    public function destroy(Appointment $appointment): Response
    {
        $appointment->medicalReport()->firstOrFail()->delete();

        return response()->noContent();
    }
}
