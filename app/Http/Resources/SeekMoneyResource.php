<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeekMoneyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $formattedCreatedAt = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');

        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'address'         => $this->address,
            'phone'           => $this->phone,
            'job'             => $this->job,
            'face_book_active'=>$this->face_book_active,
            'work_background' =>$this->work_background,
            'has_wide_netWork'=>$this->has_wide_netWork,
            'created_at'      => $formattedCreatedAt,


        ];  
      }
}
