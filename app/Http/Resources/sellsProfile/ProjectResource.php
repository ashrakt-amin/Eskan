<?php

namespace App\Http\Resources\sellsProfile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'description'     => $this->description,
            'img'             => $this->path,
            'sells'           => $this->users == null ? "null" : UserResource::collection($this->users),


        ];
    }
}
