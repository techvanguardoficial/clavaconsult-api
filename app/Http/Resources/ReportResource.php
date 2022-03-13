<?php

namespace App\Http\Resources;

use App\Models\MedicalReport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin MedicalReport
 */
class ReportResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'time' => $this->time,
            'duration' => $this->duration,
            'fields' => ReportFieldDataResource::collection($this->fieldData),
            'appointment' => $this->when($request->is('*/medical-history'), new AppointmentResource($this->appointment)),
            'status' => $this->status
        ];
    }
}
