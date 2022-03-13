<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'type' => $this->user->type,
            'admin' => $this->user->admin,
            'access_all_schedules' => $this->access_all_schedules,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
