<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'date' => $this->date,
            'amount' => $this->amount,
            'description' => $this->description,
            'appointment' => $this->when($request->is('*/payments'), new AppointmentResource($this->appointment))
        ];
    }
}
