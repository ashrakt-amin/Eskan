<?php

namespace App\Http\Resources\Social;

use Carbon\Carbon;
use App\Http\Resources\Social\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class postResource extends JsonResource
{

    public function toArray($request)
    {

      $formattedCreatedAt = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
      
       if( $this->comment_id === null){

        return [
            'id'               => $this->id,       
            'user'             => [
                'id'             => $this->user_id,
                'name'           => $this->user->name,
            ],
            'title'         => $this->title,
            'text'          => $this->text,
            'img'           => $this->img ==  null ?null : $this->path,
            'date'          => $formattedCreatedAt,
            'comments'      => CommentResource::collection($this->comments),

           
        ];

    }
  
    }
}
