<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Barryvdh\DomPDF\Facade\PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoiceController extends Controller
{
    /**
     * @throws Exception
     */
    public function show(Request $request): Response
    {
        $appointment = Appointment::find($request->query('appointment_id'));

        $data = [
            'patient' => $appointment->patient,
            'doctor' => $appointment->event->doctor,
            'amount' => $request->query('amount'),
            'date' => now()
        ];

        $pdf = PDF::loadView('invoice', $data);

        return $pdf->stream('recibo.pdf');
    }
}
