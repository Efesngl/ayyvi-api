<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "ID"=>$this->ID,
            "petiteHeader"=>$this->petite_header,
            "petiteContent"=>strip_tags($this->petite_content),
            "createdAt"=>$this->created_at,
            "petiteImage"=>$this->petite_image,
            "targetSign"=>$this->target_sign,
            "totalSigned"=>$this->total_signed,
            "creator"=>$this->creator,
            "creatorImage"=>$this->user_pp,
        ];
    }
}
