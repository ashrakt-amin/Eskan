<?php

namespace App\Http\Resources\Unit;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitTypeResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            'id'          => $this->id,
            'name'      => $this->name,
        ];
    }
}
