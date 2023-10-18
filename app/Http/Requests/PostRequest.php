<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'title'       => 'nullable',
            'text'        => 'nullable',
            'img'         => 'nullable',
           
        ];
    }

}
