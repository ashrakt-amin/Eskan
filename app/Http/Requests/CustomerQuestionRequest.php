<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerQuestionRequest extends FormRequest
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
                    'name'        => 'required',
                    'phone'       => ['required', 'regex:/^\d{7,}$/'],
                    'question'    => 'required',
                ];

            case 'PUT':
                return [
                    'phone'       => ['regex:/^\d{7,}$/'],
                ];

            default:
                return [];
        }
    }
}
