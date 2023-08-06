<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\Unit\UnitResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'phone'           => $this->phone,
            'job'             => $this->job,
            'project_id'         => [
                'id'   => $this->project_id,
                'name' => $this->project->name
            ],
            'unit' => $this->unit_id == null ? "null" : [
                'id'          => $this->unit->id,
                'number'      => $this->unit->number,
                'space'       => $this->unit->space,
                'meter_price' => $this->unit->meter_price,
                'advance'     => $this->unit->advance,
                'installment' => $this->unit->installment,
                'type'        => $this->unit->type->name,
                'level'       =>$this->unit->level->name
            ],
            'created_at'             => $this->created_at,

        
        ];
    }
}
