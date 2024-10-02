<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitorRequest extends FormRequest
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
            'job'          => 'required',
            'address'      => 'required',
            'contact_time' => 'required',
            'how'          => 'required',
            'why'          => 'required',
            'sales1'       => 'nullable',
            'sales2'       => 'nullable',
            // 'created_at'   => 'required'

        ];
    }

}
