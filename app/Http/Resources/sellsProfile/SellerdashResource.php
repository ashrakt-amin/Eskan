<?php

namespace App\Http\Resources\sellsProfile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerdashResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'phone'           => $this->phone,
            'role'            => $this->role,
            'img'             => $this->img == NULL ? NULL : $this->path,
            'projects'        => $this->Sellprojects == null ? "null" :ProjectResource::collection($this->Sellprojects),
        ];
    }
}
