<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetitionDetailResource extends JsonResource
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
            "petitionContent"=>$this->petition_content,
            "petitionImage"=>$this->petition_image,
            "petitionTopic"=>$this->petition_topic,
            "targetSign"=>$this->target_sign,
            "totalSigned"=>$this->total_signed,
            "status"=>$this->status,
            "creator"=>$this->creator
        ];
    }
}
