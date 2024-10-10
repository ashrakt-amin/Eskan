<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VisitorResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $formattedCreatedAt = Carbon::parse($this->created_at)->format('Y-m-d'  );

        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'phone'           => $this->phone,
            'job'             => $this->job,
            'address'         => $this->address,
            'contact_time'    => $this->contact_time,
            'how'             => $this->how,
            'why'             => $this->why,
            'created_at'      => $formattedCreatedAt,
            'sales1'          => $this->sales1,
            'sales2'          => $this->sales2,
            'contract'        => $this->contract,
            'feedback'        => $this->feedback,

        ];    


    }
}
