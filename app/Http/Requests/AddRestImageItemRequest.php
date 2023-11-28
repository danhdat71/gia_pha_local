<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddRestImageItemRequest extends FormRequest
{
    public function rules()
    {
        return [
            'rest_image' => ['required', 'mimes:jpeg,png,jpg', 'max:10000'], // 10mb
        ];
    }

    public function messages()
    {
        return [
            'rest_image.mimes' => ':Attribute định dạng jpeg,png,jpg',
            'rest_image.max' => ':Attribute tối đa 10MB',
        ];
    }

    public function attributes()
    {
        return [
            'rest_image' => 'Ảnh an nghỉ'
        ];
    }
}
