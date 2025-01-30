<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeekMoneyUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {

        return [
            'name'         => 'required',
            'phone'        => 'required',
            'type'         => 'required',
            'space'        => 'required',
            'advance'      => 'required',
            'installment'  => 'required',
            'feedback'     => 'nullable',
            'responsible'  => 'required',
        ];
    }
}
