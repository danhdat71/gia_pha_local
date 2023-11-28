<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RootAdminChangePasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'old_password' => [
                'required',
                function($attributes, $value, $fail) {
                    $oldPassword = Auth::guard('root_admin')->user()->password;
                    if (!Hash::check($value, $oldPassword)) {
                        return $fail(':Attribute không đúng !');
                    }
                }
            ],
            'password' => ['required', 'string', 'min:8', 'max:200'],
            're_password' => ['same:password', 'string', 'required'],
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => 'Vui lòng nhập :attribute',

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
            'old_password' => 'mật khẩu cũ',
            'password' => 'mật khẩu mới',
            're_password' => 'mật khẩu xác nhận'
        ];
    }
}
