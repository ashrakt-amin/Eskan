<?php

namespace App\Http\Resources\Unit;

use Illuminate\Http\Resources\Json\JsonResource;

class BazarResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id'          => $this->id,
            'number'      => $this->number,
            'space'       => is_int($this->space) ? (int)$this->space : (float)$this->space,
            'meter_price' => is_int($this->meter_price) ? (int)$this->meter_price : (float)$this->meter_price,
            'advance'     => is_int($this->advance) ? (int)$this->advance : (float)$this->advance,
            'installment' => is_int($this->installment) ? (int)$this->installment : (float)$this->installment,
            'img'         => $this->path,
            'revenue'     => $this->revenue,

              
        ];
    }
}
