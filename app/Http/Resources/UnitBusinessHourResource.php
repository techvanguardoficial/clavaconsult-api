<?php

namespace App\Http\Resources;

use App\Models\UnitBusinessHour;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin UnitBusinessHour
 */
class UnitBusinessHourResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'day_of_week' => $this->day_of_week,
            'start_time'  => $this->start_time,
            'end_time'    => $this->end_time,
            'is_closed'   => $this->is_closed,
        ];
    }
}
