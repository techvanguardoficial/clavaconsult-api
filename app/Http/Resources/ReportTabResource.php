<?php

namespace App\Http\Resources;

use App\Models\ReportTab;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ReportTab
 */
class ReportTabResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'fields' => ReportFieldResource::collection($this->reportFields)
        ];
    }
}
