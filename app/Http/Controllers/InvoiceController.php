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

        $address = $appointment->event->doctor->unitAddress;

        $data = [
            'patient' => $appointment->patient,
            'doctor' => $appointment->event->doctor,
            'amount' => $request->query('amount'),
            'date' => now(),
            'addressLine1' => sprintf('%s, %s, %s, %s, %s', $address->street, $address->number, $address->complementary, $address->neighborhood, $address->city),
            'addressLine2' => sprintf('%s, CEP: %s', $address->state, $address->zip_code)
        ];

        $pdf = PDF::loadView('invoice', $data);

        return $pdf->stream('recibo.pdf');
    }
}
