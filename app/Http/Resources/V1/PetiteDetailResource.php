<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetiteDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "petiteHeader"=>$this->petite_header,
            "ID"=>$this->ID,
            "petiteImage"=>$this->petite_image,
            "petiteContent"=>$this->petite_content,
            "createdAt"=>$this->created_at,
            "targetSign"=>$this->target_sign,
            "userPP"=>$this->user_pp,
            "creator"=>$this->creator,
            "totalSigned"=>$this->total_signed,
            "isSucceded"=>$this->is_succeded,
            "isSigned"=>$this->isSigned,
            "doesBelongToUser"=>$this->does_belong_to_user
        ];
    }
}
