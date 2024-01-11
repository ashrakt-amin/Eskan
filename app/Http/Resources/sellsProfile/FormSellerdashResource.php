<?php

namespace App\Http\Resources\sellsProfile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormSellerdashResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'phone'           => $this->phone,
            'date'            => $this->date,
            'seller'          =>[
                'user_id'         => $this->user_id,
                'name'         => $this->user->name,

            ]


        ];
    }
}
