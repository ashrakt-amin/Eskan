<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SouqistanboulRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required',
            'phone'       => 'required|regex:/^\d{7,}$/',
            'shopnumber'   => 'required',
        ];
    }
}
