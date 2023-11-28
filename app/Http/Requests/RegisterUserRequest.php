<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:200'],
            'email' => ['required', 'string', 'max:200', 'email', 'unique:users,email'],
            'address' => ['nullable', 'string', 'max:200'],
            'avatar' => ['nullable', 'mimes:jpeg,png,jpg', 'max:10000'], // 10mb
            'cccd_number' => ['required', 'digits_between:10,50', 'numeric'],
            'cccd_image_before' => ['required', 'mimes:jpeg,png,jpg', 'max:10000'],
            'cccd_image_after' => ['required', 'mimes:jpeg,png,jpg', 'max:10000'],
            'password' => ['required', 'string', 'min:8', 'max:200'],
            're_password' => ['same:password', 'string', 'required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng điền :attribute',
            'name.string' => ':Attribute là kiểu chuỗi ký tự',
            'name.max' => ':Attribute tối đa :max ký tự',

            'email.required' => 'Vui lòng điền :attribute',
            'email.string' => ':Attribute là kiểu chuỗi ký tự',
            'email.max' => ':Attribute tối đa :max ký tự',
            'email.email' => ':Attribute sai định dạng',
            'email.unique' => ':Attribute đã tồn tại',

            'address.string' => ':Attribute là kiểu chuỗi ký tự',
            'address.max' => ':Attribute tối đa :max ký tự',

            'avatar.mimes' => ':Attribute định dạng jpeg,png,jpg',
            'avatar.max' => ':Attribute tối đa 10MB',

            'cccd_number.required' => 'Vui lòng điền :attribute',
            'cccd_number.digits_between' => ':Attribute tối đa 10-50 ký tự',
            'cccd_number.numeric' => ':Attribute là kiểu số',

            'cccd_image_before.required' => 'Vui lòng chọn :attribute',
            'cccd_image_before.mimes' => ':Attribute định dạng jpeg,png,jpg',
            'cccd_image_before.max' => ':Attribute tối đa 10MB',

            'cccd_image_after.required' => 'Vui lòng chọn :attribute',
            'cccd_image_after.mimes' => ':Attribute định dạng jpeg,png,jpg',
            'cccd_image_after.max' => ':Attribute tối đa 10MB',

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
            'name' => 'họ tên',
            'email' => 'email',
            'address' => 'địa chỉ',
            'avatar' => 'ảnh đại diện',
            'cccd_number' => 'mã cccd',
            'cccd_image_before' => 'ảnh mặt trước cccd',
            'cccd_image_after' => 'ảnh mặt sau cccd',
            'password' => 'mật khẩu',
            're_password' => 'mật khẩu xác nhận',
        ];
    }
}
