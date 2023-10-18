<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [

            'comment'        => 'required',
            'post_id'        => 'required',
            'comment_id'     => 'nullable',
            'number'         => 'nullable'

        ];
    }

    public function messages()
    {
        return [
            'comment.required'          => 'النص مطلوب',
           
        ];
    }
}
