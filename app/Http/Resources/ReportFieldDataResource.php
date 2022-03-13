<?php

namespace App\Http\Resources;

use App\Models\ReportFieldData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ReportFieldData
 */
class ReportFieldDataResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'report_field_id' => $this->report_field_id,
            'value' => $this->value
        ];
    }
}
