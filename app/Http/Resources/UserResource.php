<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        switch ($this->type) {
            case 'doctor':
                return [
                    'id' => $this->profile->id, // TODO: Por enquanto o ID é o do usuário relacionado.
                    'name' => $this->name,
                    'company_name' => $this->company_name,
                    'email' => $this->email,
                    'role' => $this->type,
                    'admin' => $this->admin,
                    'specialty' => $this->profile->specialty
                ];
            default:
                return [
                    'id' => $this->profile->id, // TODO: Por enquanto o ID é o do usuário relacionado.
                    'name' => $this->name,
                    'email' => $this->email,
                    'role' => $this->type,
                    'admin' => $this->admin
                ];
        }
    }
}
