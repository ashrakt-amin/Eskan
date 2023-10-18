<?php

namespace App\Http\Resources\Social;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminCommentResource extends JsonResource
{

    public function toArray($request)
    {

       $formattedCreatedAt = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
        return [
            'id'               => $this->id,       
            'comment'          => $this->comment,
             'date'            => $formattedCreatedAt,

          
        ];


    }
}
