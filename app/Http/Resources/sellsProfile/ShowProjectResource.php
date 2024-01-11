<?php

namespace App\Http\Resources\sellsProfile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'description'     => $this->description,
            'img'             => $this->path,
            'users'           => $this->users == null ? "null" : UserResource::collection($this->users),
// ,
//             'users'=>[
//            'id'         => $this->users->id,
//             'name'      => $this->users->name,
//             'phone'     => $this->users->phone,
//             'role'      => $this->users->role,
//             'parent'    => $this->users->parent_id == NULL ? NULL :
//             [
//                 'id'=> $this->users->parent_id ,
//                 'name'=>$this->users->parent->name 
//             ],
//             ]
        ];
    }
}
