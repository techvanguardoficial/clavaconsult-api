<?php

namespace App\Http\Resources;

use App\Models\Plan;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Plan
 */
class DoctorPlanResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'consultation_value' => $this->pivot->consultation_value,
            'observations' => $this->pivot->observations,
        ];
    }
}
