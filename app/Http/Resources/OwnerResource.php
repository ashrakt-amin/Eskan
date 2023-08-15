<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
        $formattedCreatedAt = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');

        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'phone'       => $this->phone,
            'job'         => $this->job,
            'address'     => $this->address,
            'unit_type'   => $this->unit_type,
            'price'       => $this->price,
            'premium'     => $this->premium,
            'created_at'  => $formattedCreatedAt,
            'feedback'        => $this->feedback


        ];
    }
}
