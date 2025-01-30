<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeekMoneyUpdateResource extends JsonResource
{
    public function toArray($request)
    {
        $formattedCreatedAt = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');

        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'phone'        => $this->phone,
            'type'         => $this->type,
            'space'        => $this->space,
            'advance'      => $this->advance,
            'installment'  => $this->installment,
            'feedback'     => $this->feedback,
            'responsible'  => $this->responsible,
            'created_at'   => $formattedCreatedAt,



        ];
    }
}
