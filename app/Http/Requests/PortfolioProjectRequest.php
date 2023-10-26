<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioProjectRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => 'required',
            'img'          => 'required',
            'address'      => 'required',
            'resale'       => 'required',
            'link'         => 'nullable',
            'description'  => 'required',
            'detalis'      => 'required',
            'features'     => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.required'          => 'الاسم مطلوب',
            'img.required'           => 'الصوره مطلوبه',
            'address.required'       => 'العنوان مطلوب',
            'resale.required'        => 'ارباح اعاده البيع مطلوب',
            'description.required'   => 'الوصف مطلوب',
            'detalis.required'       => 'التفاصيل مطلوبه',
           
        ];
    }
}
