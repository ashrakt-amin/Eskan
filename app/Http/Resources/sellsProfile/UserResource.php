<?php

namespace App\Http\Resources\sellsProfile;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // if ($this->parent === null) {
        //     return [];
        // }
        return [

            'id'        => $this->id,
            'name'      => $this->name,
            'img   '    => $this->img == NULL ? NULL : $this->path ,
            'phone'     => $this->phone,
            'role'      => $this->role,
            'parent'    => $this->parent_id == NULL ? NULL :
            [
                'id'=> $this->parent_id ,
                'name'=>$this->parent->name 
            ],
            // 'sells'    => $this->children == NULL ? NULL : UserResource::collection($this->children)
         
        ];
    
    }
}
