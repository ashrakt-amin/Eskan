<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OwnerRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required',
            'phone'       => 'required|unique:owners,phone|regex:/^\d{7,}$/',
            'job'         => 'nullable',
            'address'     => 'nullable',
            'unit_type'   => 'nullable',
            'price'       => 'nullable',
            'premium'     => 'required',
            'place'       => 'nullable',
            'feedback'    => 'nullable',
        ];
    }
}
