<?php

namespace App\Http\Resources\ai;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SellProject\ProjectResource;

class NafieResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'phone'       => $this->phone,
            'type'        => $this->type,
        ];
    }
}
