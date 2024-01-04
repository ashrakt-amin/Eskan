<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                    'phone'     => 'required|unique:users,phone',
                    'password'  => 'required',              
                ];
            default:
                return [];
        }
    }
}
