<?php

namespace App\Http\Resources\sellsProfile;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class parentSellsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
       
        return [

            'id'        => $this->id,
            'name'      => $this->name,
            'img   '    => $this->img == NULL ? NULL : $this->path ,
            'phone'     => $this->phone,
            'role'      => $this->role,
            'projects'        => $this->Sellprojects == null ? "null" :ProjectResource::collection($this->Sellprojects),

          
         
        ];
    
    }
}
