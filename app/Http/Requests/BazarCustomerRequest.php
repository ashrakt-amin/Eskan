<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BazarCustomerRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => 'required',
            'phone'        => 'required',
            'bazar_number' => 'required',
            'feedback'     => 'nullable',

        ];
    }
}
