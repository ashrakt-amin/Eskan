<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeekMoneyResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'address'         => $this->address,
            'phone'           => $this->phone,
            'job'             => $this->job,
            'face_book_active'=>$this->face_book_active,
            'work_background' =>$this->work_background,
            'has_wide_netWork'=>$this->has_wide_netWork,

        ];  
      }
}
