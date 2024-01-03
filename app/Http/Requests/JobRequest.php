<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }



    public function rules(): array
    {
        //|unique:jobs,phone
        return [
            'job_title'          => 'nullable',
            'name'               => 'required',
            'phone'              => ['required', 'regex:/^\d{7,}$/'],
            'cv'                 => 'required',
            'person_img'         => 'nullable',
            'last_project'       => 'nullable',
            'last_project_info'  => 'nullable',
            'feedback'           => 'nullable',
            'facebook'           => 'nullable',
        ];
    }
}
