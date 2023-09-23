<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BazarCustomerResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $formattedCreatedAt = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');

        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'phone'           => $this->phone,
            'bazar_number'    => $this->bazar_number,
            'created_at'      => $formattedCreatedAt,
            'feedback'        => $this->feedback


        ];    


    }
}
