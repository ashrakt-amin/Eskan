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
            'phone'        => ['required','regex:/^\d{7,}$/'],
            'bazar_number' => 'required',
            'section'      => 'nullable',
            'feedback'     => 'nullable',

        ];
    }
}
