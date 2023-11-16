<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlockRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'         => 'required',
            'project_id'   => 'required',
            'img'          => 'required',
           
        ];
    }

}
