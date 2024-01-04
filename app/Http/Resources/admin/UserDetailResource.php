<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "firstname"=>$this->firstname,
            "lastname"=>$this->lastname,
            "email"=>$this->email,
            "userPP"=>$this->user_pp,
            "password"=>null
        ];
    }
}
