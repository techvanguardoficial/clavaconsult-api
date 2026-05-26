<?php

namespace App\Http\Resources;

use App\Models\UnitRoom;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin UnitRoom
 */
class UnitRoomResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'              => $this->id,
            'unit_address_id' => $this->unit_address_id,
            'name'            => $this->name,
            'description'     => $this->description,
        ];
    }
}
