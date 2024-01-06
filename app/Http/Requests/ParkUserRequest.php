<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParkUserRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id'   => 'required',
            'name'         => 'required',
            'phone'        => ['required', 'regex:/^\d{7,}$/'],
            'job'          => 'nullable',
            'national_ID'  => 'nullable',
            'space'        => 'nullable',
            'products_type' => 'nullable',
            'type'          => 'required',
            'feedback'      => 'nullable',

        ];
    }
}
