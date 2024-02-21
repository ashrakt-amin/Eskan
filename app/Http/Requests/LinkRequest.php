<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinkRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }



    public function rules(): array
    {
        //|unique:jobs,phone
        return [
            'name'               => 'required',
            'link'               => 'required',

        ];
    }
}
