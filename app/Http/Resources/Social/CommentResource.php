<?php

namespace App\Http\Resources\Social;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Social\AdminCommentResource;

class CommentResource extends JsonResource
{

    public function toArray($request)
    {

      $formattedCreatedAt = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
      
       if( $this->comment_id === null){

        return [
            'id'               => $this->id,       
            'comment'          => $this->comment,
            'date'             => $formattedCreatedAt,
            'admin_Comment'     =>new AdminCommentResource($this->admin_comment),
           
        ];

    }
  
    }
}
