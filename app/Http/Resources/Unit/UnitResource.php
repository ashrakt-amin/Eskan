<?php

namespace App\Http\Resources\Unit;

use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id'          => $this->id,
            'number'      => $this->number,
            'contract'    => $this->contract,
            'rooms'       => $this->rooms,
            'duration'    => $this->duration,
            'space'       => is_int($this->space) ? (int)$this->space : (float)$this->space,
            'meter_price' => is_int($this->meter_price) ? (int)$this->meter_price : (float)$this->meter_price,
            'advance_rate' => (int)$this->advance_rate,
            'advance'     => is_int($this->advance) ? (int)$this->advance : (float)$this->advance,
            'installment' => is_int($this->installment) ? (int)$this->installment : (float)$this->installment,
            'type'        => $this->type->name,
            'project'     => $this->project->name,
            'level_id'                  => [
                'id'     => $this->level_id,
                'name'   => $this->level->name,
            ],
            'levelimg'             => $this->levelimg == null ? "null" : $this->levelimgpath,
            'img'             => $this->img == null ? "null" : $this->path,
            'images'     => $this->unitImage == null ? "null" : [
                'unit_img'    => $this->unitImage->unitpath,
                'block_img'   => $this->unitImage->blockpath,
            ],
            'block_id'        => $this->block_id == null ? "null" :  [
                'id'     => $this->block_id,
                'name'   => $this->block->name,
            ],
            'appear'     => $this->appear,
            'revenue'    => is_int($this->revenue) ? (int)$this->revenue : (float)$this->revenue,
            'step'       => $this->step,

        ];
    }
}
