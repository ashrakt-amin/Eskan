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
            'phone'          => ['required','regex:/^\d{7,}$/'],
            'shares_num'     => 'required',
            'walletunit_id'  => 'required',
            'feedback'       => 'nullable',


        ];
    }
}
