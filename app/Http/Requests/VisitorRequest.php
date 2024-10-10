<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitorRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'         => 'required',
            'phone'        => 'required|unique:visitors,phone',
            'job'          => 'required',
            'address'      => 'required',
            'contact_time' => 'required',
            'how'          => 'required',
            'why'          => 'required',
            'sales1'       => 'nullable',
            'sales2'       => 'nullable',
            'feedback'     => 'nullable'
            // 'created_at'   => 'required'

        ];
    }

    public function messages()
    {
       
            return [
            'name.required'         => 'الاسم مطلوب',
            'phone.required'        => 'الهاتف مطلوب',
            'job.required'          => 'الوظيفه مطلوبه',
            'address.required'      => 'العنوان مطلوب',
            'contact_time.required' => 'التاريخ مطلوب',
            'how.required'          => 'كيف عرفتنا مطلوب',
            'why.required'          => 'الغرض مطلوب',
            'phone.unique'          => 'الهاتف موجود بالفعل',
            ];
       
    }

}
