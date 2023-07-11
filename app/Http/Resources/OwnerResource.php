<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'phone'       => $this->phone,
            'job'         => $this->job,
            'address'     => $this->address,
            'unit_type'   => $this->unit_type,
            'price'       => $this->price,
            'premium'     => $this->premium
        ];
    }
}
