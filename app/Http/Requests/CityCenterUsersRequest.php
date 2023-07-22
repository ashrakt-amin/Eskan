<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityCenterUsersRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => 'required',
            'phone'   => 'required',
            'job'     => 'required',
            'address' => 'required',
            'space'   => 'required',
            'activity'=> 'required',
            'job'     => 'required'


        ];
    }
}
