<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
       $formattedCreatedAt = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'job'         => $this->job,
            'address'     => $this->address,
            'phone'       => $this->phone,
            'whats'       => $this->whats,
            'join_reason' => $this->join_reason,
            'average_money' => $this->average_money,
            'installement'=> $this->installement,
            'feedback'    => $this->feedback,
            'created_at'      => $formattedCreatedAt,
            
        ];
    }
}
