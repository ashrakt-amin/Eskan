<?php

namespace App\Http\Resources\sellsProfile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerProjectdashResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'description'     => $this->description,
            'img'             => $this->path
        ];
    }
}
