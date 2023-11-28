<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\UserType;

class AdminRegisterUserRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'user_type' => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:200'],
            'email' => ['required', 'string', 'max:200', 'email', 'unique:users,email'],
            'address' => ['nullable', 'string', 'max:200'],
            'avatar' => ['nullable', 'mimes:jpeg,png,jpg', 'max:10000'], // 10mb
        ];

        if (request('user_type') == UserType::USER) {
            $rules['cccd_number'] = ['required', 'digits_between:10,50', 'numeric'];
            $rules['cccd_image_before'] = ['required', 'mimes:jpeg,png,jpg', 'max:10000']; // 10mb
            $rules['cccd_image_after'] = ['required', 'mimes:jpeg,png,jpg', 'max:10000']; // 10mb
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'user_type.required' => 'Vui lòng chọn :attribute',
            'user_type.numeric' => ':Attribute là kiểu số',

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
        ];
    }

    public function attributes()
    {
        return [
            'user_type' => 'loại user',
            'name' => 'họ tên',
            'email' => 'email',
            'address' => 'địa chỉ',
            'avatar' => 'ảnh đại diện',
            'cccd_number' => 'mã cccd',
            'cccd_image_before' => 'ảnh mặt trước cccd',
            'cccd_image_after' => 'ảnh mặt sau cccd',
        ];
    }
}
