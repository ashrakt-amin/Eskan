<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BazarRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'number'      => 'required',
            'space'       => 'required',
            'meter_price' => 'required',
            'advance'     => 'nullable',
            'installment' => 'required',
            'img'         => 'required',
            'revenue'     => 'nullable',
            'contract'    => 'nullable',
            'section'     => 'nullable',


        ];
    }
}
