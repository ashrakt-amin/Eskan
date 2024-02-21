<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            'id'                 => $this->id,
            'name'               => $this->name,
            'link'               => $this->link

        ];
    }
}
