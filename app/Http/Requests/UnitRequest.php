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
            'contract'    => 'nullable',
            'rooms'       => 'nullable',
            'duration'    => 'required',
            'meter_price' => 'required',
            'advance_rate'=> 'nullable',
            'advance'     => 'nullable',
            'installment' => 'required',
            'type_id'     => 'required',
            'project_id'  => 'required',
            'level_id'    => 'required',
            'unit_image_id' => 'nullable',
            'block_id'      => 'required' ,
            'appear'        => 'nullable',
            'levelimg'      => 'nullable',
            'step'          => 'nullable',
            'img'           => 'nullable',
            
        ];
    }
}
