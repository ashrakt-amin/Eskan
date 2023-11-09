<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParkUserResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $formattedCreatedAt = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');

        return [
            'id'              => $this->id,
            'project_id'      => $this->project->name,
            'name'            => $this->name,
            'phone'           => $this->phone,
            'job'             => $this->job,
            'national_ID'     => $this->national_ID,
            'space'           => $this->space,
            'products_type'   => $this->products_type,
            'type'            => $this->type,
            'created_at'      => $formattedCreatedAt,
            'feedback'        => $this->feedback

        ];
    }
}
