<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SellProject\ProjectResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id'        => $this->id,
            'name'      => $this->name,
            'phone'     => $this->phone,
            'role'      => $this->role,
            'img'       => $this->img == NULL ? NULL : $this->path,
            'parent'    => $this->parent_id == NULL ? NULL :
            [
                'id'=> $this->parent_id ,
                'name'=>$this->parent->name 
            ],
           'projects' => $this->Sellprojects == NULL ? NULL : ProjectResource::collection($this->Sellprojects),

        ];
    }
}
