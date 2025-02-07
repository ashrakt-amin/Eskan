<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SouqistaboulformRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'         => 'required',
            'phone'        => 'required',
            'shop_number'  => 'required',
            'region'       => 'required',
            'contact_time' => 'required',

        ];
    }

}
