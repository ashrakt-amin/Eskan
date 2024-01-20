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
                    'name'      => 'required|unique:users|max:255',
                    'password'  => 'required|unique:users|min:6',
                    'phone'     => 'required',
                    'role'      => 'required',
                    'img'       => 'nullable',
                    'parent_id' => 'nullable'
                   
                ];
            default:
                return [];
        }
    }
}
