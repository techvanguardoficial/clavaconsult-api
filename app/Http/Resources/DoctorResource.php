<?php

namespace App\Http\Resources;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Doctor
 */
class DoctorResource extends JsonResource
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
            'role' => $this->user->type,
            'admin' => $this->user->admin,
            'specialty' => $this->specialty,
            'cpf' => $this->cpf,
            'council_type' => $this->council_type,
            'council_number' => $this->council_number
        ];
    }
}
