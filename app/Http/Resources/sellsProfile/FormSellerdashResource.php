<?php

namespace App\Http\Resources\sellsProfile;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormSellerdashResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $formattedCreatedAt = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');


        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'phone'           => $this->phone,
            'date'            => $this->date,
            'status'          => $this->status == 0 ? false : true,
            'created_at'      => $formattedCreatedAt ,
            // 'seller'          =>[
            //     'user_id'         => $this->user_id,
            //     'name'         => $this->user->name,
            // ],
            // 'project'          =>[
            //     'sellproject_id'  => $this->sellproject_id,
            //     'name'            => $this->sellproject->name,
            // ]
        ];
    }
}
