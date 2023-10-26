<?php

namespace App\Http\Resources\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class projectFile extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            
            'id'              => $this->id,
            'file'           => $this->path

        ];  
      }
} 
