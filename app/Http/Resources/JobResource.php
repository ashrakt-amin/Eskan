<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        $formattedCreatedAt = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');

        return [

            'id'                 => $this->id,
            'job_title'          => $this->job_title,
            'name'               => $this->name,
            'phone'              => $this->phone,
            'cv'                 => $this->path,
            'person_img'         => $this->person_img == null ? "null" : $this->person,
            'last_project'       => $this->last_project == null ? "null" : $this->project,
            'last_project_info'  => $this->last_project_info,
            'feedback'           => $this->feedback,
            'facebook'           => $this->facebook,
            'created_at'         => $formattedCreatedAt,

        ];
    }
}
