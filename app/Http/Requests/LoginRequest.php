<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function rules()
    {
        return [
            'login_id' => ['required', 'string'],
            'password' => ['required', 'string']
        ];
    }

    public function messages()
    {
        return [
            'login_id.required' => 'Vui lòng điền :attribute',
            'login_id.string' => 'Vui lòng cung cấp kiểu chuỗi',

            'password.required' => 'Vui lòng điền :attribute',
            'password.string' => 'Vui lòng cung cấp kiểu chuỗi',
        ];
    }

    public function attributes()
    {
        return [
            'login_id' => 'email hoặc mã căn cước',
            'password' => 'mật khẩu',
        ];
    }
}
