<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\Unit\UnitResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $formattedCreatedAt = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
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
                'installment' => $this->unit->installment == null ? "null" : $this->unit->installment ,
                'type'        => $this->unit->type->name ,
                'level'       => $this->unit->level->name,
                'block'       => $this->unit->block == null ? "null" : $this->unit->block->name
            ],
            'created_at'      => $formattedCreatedAt,
            'feedback'        => $this->feedback,
            'contact_time'    => $this->contact_time,
        ];
    }
}
