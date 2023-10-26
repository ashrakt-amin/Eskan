<?php

namespace App\Http\Resources\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class projectWallet extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            
            'id'              => $this->id,
            'name'            => $this->name,
            'img'             => $this->path,
            'address'         => $this->address,
            'resale'          => $this->resale,
            'link'            => $this->link,
            'description'     => $this->description,
            'detalis'         => $this->detalis,
            'features'        => $this->features,

        ];  
      }
}
