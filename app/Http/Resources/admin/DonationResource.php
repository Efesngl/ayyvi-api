<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "donator"=>$this->donator,
            "amount"=>$this->donation_amount,
            "donatedAt"=>$this->donated_at,
            "donatorID"=>$this->donator_id
        ];
    }
}
