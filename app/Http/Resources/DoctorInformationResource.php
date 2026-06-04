<?php

namespace App\Http\Resources;

use App\Models\DoctorInformation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin DoctorInformation
 */
class DoctorInformationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'key'         => $this->key,
            'information' => $this->information,
            'active'      => $this->active,
        ];
    }
}
