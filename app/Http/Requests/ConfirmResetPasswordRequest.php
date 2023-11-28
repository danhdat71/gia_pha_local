<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmResetPasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'token_reset' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'max:200'],
            're_password' => ['same:password', 'string', 'required'],
        ];
    }

    public function messages()
    {
        return [
            'token_reset.required' => 'Vui lòng cung cấp :attribute',
            'token_reset.string' => ':Attribute là dạng chuỗi',

            'password.required' => 'Vui lòng nhập :attribute',
            'password.string' => ':Attribute là dạng chuỗi',
            'password.min' => ':Attribute tối thiểu :min ký tự',
            'password.max' => ':Attribute tối đa :max ký tự',

            're_password.same' => ':Attribute không khớp',
            're_password.string' => ':Attribute là dạng chuỗi',
            're_password.required' => 'Vui lòng nhập :attribute',
        ];
    }

    public function attributes()
    {
        return [
            'token_reset' => 'token reset',
            'password' => 'mật khẩu',
            're_password' => 'mật khẩu xác nhận'
        ];
    }
}
