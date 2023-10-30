<?php

namespace App\Http\Resources\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class projectWalletShow extends JsonResource
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
            'detalis'         => $this->detalis,
            'description'     => $this->description,
            'features'        => $this->features,
            'files'           => $this->files == null ? "null" :projectFile::collection($this->files),


        ];  
      }
}
