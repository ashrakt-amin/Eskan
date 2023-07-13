<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
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
            'img'         => 'required',
            'contract'    => 'nullable',
            'rooms'       => 'required',
            'duration'    => 'required',
            'meter_price' => 'required',
            'advance_rate'=> 'required',
            'advance'     => 'nullable',
            'installment' => 'required',
            'type_id'     => 'required',
            'project_id'  => 'required',
            'level_id'    => 'required',

        ];
    }
}
