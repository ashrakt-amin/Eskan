<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{

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
            'whats'       => $this->whats,
            'join_reason' => $this->join_reason,
            'feedback'    => $this->feedback
            
        ];
    }
}
