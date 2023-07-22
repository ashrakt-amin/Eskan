<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityCenterUsersResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'phone'           => $this->phone,
            'address'         => $this->address,
            'space'           => $this->space,
            'activity'        => $this->activity,
            'job'             => $this->job
        ];    


    }
}
