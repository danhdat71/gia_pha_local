<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCertImageItemRequest extends FormRequest
{
    public function rules()
    {
        return [
            'cert_image' => ['required', 'mimes:jpeg,png,jpg', 'max:10000'], // 10mb
        ];
    }

    public function messages()
    {
        return [
            'cert_image.mimes' => ':Attribute định dạng jpeg,png,jpg',
            'cert_image.max' => ':Attribute tối đa 10MB',
        ];
    }

    public function attributes()
    {
        return [
            'cert_image' => 'Ảnh chứng chỉ'
        ];
    }
}
