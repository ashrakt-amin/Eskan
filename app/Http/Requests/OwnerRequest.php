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
            'phone'       => 'required|unique:owners,phone',
            'job'         => 'required',
            'address'     => 'required',
            'unit_type'   => 'required',
            'price'       => 'required',
            'premium'     => 'required'

        ];
    }
}
