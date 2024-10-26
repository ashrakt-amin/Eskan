<?php

namespace App\Http\Resources;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
      
    public function toArray(Request $request): array
    {
 $formattedCreatedAt = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
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
