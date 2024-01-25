<?php

namespace App\Http\Resources\sellsProfile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellsSiteResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'phone'           => $this->parent == null ? $this->phone : $this->parent->phone,
            'img'             => $this->img == null ? "null" : $this->path,
        ];
    }
}
