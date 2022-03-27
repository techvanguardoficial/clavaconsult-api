<?php

namespace App\Http\Resources;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Payment
 */
class PaymentResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'patientName' => $this->appointment->patient->name,
            'appointmentType' => $this->appointment->type,
            'amount' => $this->amount,
            'description' => $this->description,
            'appointment' => $this->when($request->is('*/payments'), new AppointmentResource($this->appointment))
        ];
    }
}
