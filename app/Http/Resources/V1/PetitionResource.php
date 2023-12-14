<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetitionResource extends JsonResource
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
            "petitionHeader"=>$this->petition_header,
            "petitionContent"=>strip_tags($this->petition_content),
            "createdAt"=>$this->created_at,
            "petitionImage"=>$this->petition_image,
            "targetSign"=>$this->target_sign,
            "totalSigned"=>$this->total_signed,
            "creator"=>$this->creator,
            "creatorImage"=>$this->user_pp,
        ];
    }
}
