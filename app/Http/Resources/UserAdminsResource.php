<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SellProject\ProjectResource;

class UserAdminsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id'        => $this->id,
            'name'      => $this->name,
            'role'      => $this->role,
        ];
    }
}
