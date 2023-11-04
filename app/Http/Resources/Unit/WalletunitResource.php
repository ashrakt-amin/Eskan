<?php

namespace App\Http\Resources\Unit;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletunitResource extends JsonResource
{
    public function toArray($request)
    {
       
        return [
            'id'     => $this->id,
            'img'    => $this->path,
            'num'    => $this->num,
            'shares_num'          => $this->shares_num,
            'contracted_shares'   =>$this->contracted_shares == null ? "null" :$this->contracted_shares ,
            'share_price'         => $this->share_price,
            'share_meter_num'     => $this->share_meter_num,
            'return'              => $this->return,
           

        ];
    }
}
