<?php

namespace App\Http\Resources\Project;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if (preg_match('/pcImage/i', $this->img)) {
            $img = "pcImage";
            $image_path = $this->path;
        } elseif (preg_match('/mobileImage/i', $this->img)) {
            $img = "mobileImage";
            $image_path = $this->path;
        } else{
            $img = "img";
            $image_path = NULL;

        }

        return [
            'id'        => $this->id,
            $img        => $image_path,
        ];
    }
}
