<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UseWalletResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $formattedCreatedAt = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');

        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'phone'           => $this->phone,
            'shares_num'      => $this->shares_num,
            'walletunit_num'  => $this->unit->num,
            'walletunit_project'  => $this->unit->project->name,
            'created_at'      => $formattedCreatedAt,
            'feedback'        => $this->feedback
            

        ];    


    }
}
