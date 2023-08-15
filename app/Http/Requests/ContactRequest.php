<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required',
            'phone'       => 'required|unique:contact_us,phone',
            'unit_type'   => 'required',
            'feedback' =>'nullable',

        ];
    }
}
