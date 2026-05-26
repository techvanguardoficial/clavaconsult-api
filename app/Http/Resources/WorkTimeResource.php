<?php

namespace App\Http\Resources;

use App\Models\WorkTime;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin WorkTime
 */
class WorkTimeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'day_of_week'  => $this->day_of_week,
            'period'       => $this->period,
            'start_time'   => $this->start_time,
            'end_time'     => $this->end_time,
            'unit_room_id'   => $this->unit_room_id,
            'unit_room_name' => $this->unitRoom?->name,
            'observations'   => $this->observations,
        ];
    }
}
