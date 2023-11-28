<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePrVideoRequest extends FormRequest
{
    public function rules()
    {
        return [
            // 'url' => ['required', 'mimes:mp4,mov', 'max:100000'], // 100mb
            'url' => ['required', 'max:255'], // 100mb
        ];
    }

    public function messages()
    {
        return [
            'url.required' => 'Vui chọn :attribute',
            'url.mimes' => ':Attribute định dạng mp4 hoặc mov',
            // 'url.max' => ':Attribute tối đa 100MB',
            'url.max' => ':Attribute tối đa 255 ký tự',
        ];
    }

    public function attributes()
    {
        return [
            'url' => 'video an nghỉ 360',
        ];
    }
}
