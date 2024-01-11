<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FormSellRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name'      => 'required',
                    'phone'     => ['required', 'regex:/^\d{7,}$/'],
                    'date'      => 'required',
                    'user_id'   => 'required',
                   
                ];
            default:
                return [];
        }
    }
}
