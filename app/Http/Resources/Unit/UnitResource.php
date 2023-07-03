<?php

namespace App\Http\Resources\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            'id'          => $this->id,
            'number'      => $this->number,
            'space'       => $this->space,
            'meter_price' => $this->meter_price,
            'advance'     => $this->advance,
            'installment' => $this->installment,
            'type'     => $this->type->name,
            'project'  => $this->project->name,        ];  
      }
}
