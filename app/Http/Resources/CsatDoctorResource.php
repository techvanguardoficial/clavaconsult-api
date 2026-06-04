<?php

namespace App\Http\Resources;

use App\Models\CsatDoctorResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CsatDoctorResponse
 */
class CsatDoctorResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'patient_id'     => $this->patient_id,
            'appointment_id' => $this->appointment_id,
            'score'          => $this->score,
            'comment'        => $this->comment,
            'source'         => $this->source,
            'responded_at'   => $this->responded_at,
            'created_at'     => $this->created_at,
        ];
    }
}
