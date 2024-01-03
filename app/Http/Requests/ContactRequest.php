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
            'phone'       => 'required|unique:contact_us,phone|regex:/^\d{7,}$/',
            'unit_type'   => 'required',
            'feedback'    => 'nullable',
            'space'       => 'required', 
            'breif'       => 'required', 
        ];
    }
}
