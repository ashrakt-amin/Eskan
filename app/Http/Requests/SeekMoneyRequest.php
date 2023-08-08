<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeekMoneyRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {

        return [
            'name'                => 'required',
            'address'             => 'required',
            'phone'               => 'required|unique:seek_money,phone',
            'job'                 => 'required',
            'face_book_active'    => 'nullable',
            'work_background'     => 'required',
            'has_wide_netWork'    => 'required',

        ];
    }


    
}
