<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserWalletRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
      
        return [
            'name'           => 'required',
            'phone'          => 'required',
            'shares_num'     => 'required',
            'walletunit_id'  => 'required',
            'feedback'       => 'nullable',


        ];
    }
}
