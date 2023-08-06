<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'phone'           => $this->phone,
            'unit_type'       => $this->unit_type,
            'created_at'      => $this->created_at,

        ];    


    }
}
