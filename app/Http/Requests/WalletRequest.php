<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WalletRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name'          => 'required',
            'job'           => 'required',
            'address'       => 'required',
            'phone'         => ['required', 'regex:/^\d{7,}$/'],
            'whats'         => 'nullable',
            'join_reason'   => 'required',
            'average_money' => 'required',
            'installement'  => 'required',
            'feedback'      => 'nullable'

        ];
    }
}

