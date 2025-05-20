<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->bookingId,
            'tour'=>[
                'title'=>optional($this->tour)->title,
                'destination'=>optional($this->tour)->destination,
            ],
            'quantiy'=>$this->quantity,
        ];
    }
}
