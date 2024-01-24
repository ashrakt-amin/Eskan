<?php

namespace App\Http\Resources\Unit;

use Illuminate\Http\Resources\Json\JsonResource;

class CommercialResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id'          => $this->id,
            'duration'    => $this->duration,
            'number'      => $this->number,
            'space'       => is_int($this->space) ? (int)$this->space : (float)$this->space,
            'meter_price' => is_int($this->meter_price) ? (int)$this->meter_price : (float)$this->meter_price,
            'advance'     => is_int($this->advance) ? (int)$this->advance : (float)$this->advance,
            'type'        => $this->type->name,
            'project'     => $this->project->name,
            'level_id'                  => [
                'id'     => $this->level_id,
                'name'   => $this->level->name,
            ],
            'img'                  =>$this->img == null ? "null" : $this->path ,
            'images'                  =>$this->unitImage == null ? "null" : [
                'unit_img'     => $this->unitImage->unitpath,
                'block_img'   => $this->unitImage->blockpath,
            ],
            'appear'     =>$this->appear

        ];
    }
}
