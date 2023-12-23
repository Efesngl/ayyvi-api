<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetiteEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "petitionHeader"=>$this->petition_header,
            "ID"=>$this->ID,
            "petitionImage"=>$this->petition_image,
            "petitionContent"=>$this->petition_content,
            "createdAt"=>$this->created_at,
            "targetSign"=>$this->target_sign,
            "totalSigned"=>$this->total_signed,
            "isSucceded"=>$this->is_succeded,
            "petitionTopic"=>$this->petition_topic,
        ];
    }
}