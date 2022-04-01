<?php

namespace App\Http\Resources;

use App\Models\CID;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CID
 */
class CIDResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'code' => $this->code,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
