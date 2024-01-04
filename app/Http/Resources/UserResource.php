<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

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
        ];
    }
}
