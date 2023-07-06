<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {

        return [
            'name'      => 'required',
            'phone'     => 'required',
            'job'       => 'required',
            'project_id'=> 'required',
            'unit_id'   => 'nullable',


        ];
    }
}
