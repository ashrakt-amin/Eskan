<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WalletUnitRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        
        return [
            'project_id'        => 'required',
            'img'               => 'required',
            'num'               => 'required',
            'level'             => 'required',
            'shares_num'        => 'required',
            'contracted_shares' => 'nullable',
            'share_price'       => 'required',
            'share_meter_num'   => 'required',
            'return'            => 'required',
            
        ];
    }
}
