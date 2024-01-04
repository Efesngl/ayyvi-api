<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "username"=>$this->firstname." ".$this->lastname,
            "email"=>$this->email,
            "registeredAt"=>$this->registered_at,
            "ID"=>$this->ID
        ];
    }
}
