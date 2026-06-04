<?php

namespace App\Http\Resources;

use App\Models\CsatReceptionistResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CsatReceptionistResponse
 */
class CsatReceptionistResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'patient_id'     => $this->patient_id,
            'appointment_id' => $this->appointment_id,
            'employee_id'    => $this->employee_id,
            'score'          => $this->score,
            'comment'        => $this->comment,
            'source'         => $this->source,
            'responded_at'   => $this->responded_at,
            'created_at'     => $this->created_at,
        ];
    }
}
