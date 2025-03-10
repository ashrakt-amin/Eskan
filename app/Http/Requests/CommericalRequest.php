<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommericalRequest extends FormRequest
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
            'contract'    => 'nullable',
            'rooms'       => 'nullable',
            'duration'    => 'required',
            'meter_price' => 'required',
            'advance_rate'=> 'nullable',
            'advance'     => 'required',
            'installment' => 'nullable',
            'type_id'     => 'required',
            'project_id'  => 'required',
            'level_id'    => 'required',
            'block_id'    => 'nullable',
            'img'         => 'nullable',
            'unit_image_id' => 'nullable',
            'appear'        => 'nullable',
            'step'          => 'nullable',




        ];
    }
}
