<?php

namespace App\Http\Requests;

use App\Constants\Relation;
use Illuminate\Foundation\Http\FormRequest;

class CreateFirstMemberRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'fullname' => ['required', 'max:200', 'string'],
            'role_name' => ['required', 'max:200', 'string'],
            'avatar' => ['required', 'mimes:jpeg,png,jpg', 'max:10000'], // 10mb
            'birthday' => ['required', 'date_format:Y-m-d'],
            'leaveday' => ['nullable', 'date_format:Y-m-d'],
            'address' => ['nullable', 'max:200', 'string'],
            'email' => ['nullable', 'email', 'max:200'],
            'phone' => ['nullable', 'digits_between:8,13'],
            'story' => ['nullable', 'string'],
            'gender' => ['required', 'digits_between: 1,2'],
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'fullname.required' => 'Vui lòng điền :attribute',
            'fullname.max' => ':Attribute tối đa :max ký tự',
            'fullname.string' => ':Attribute dạng chuỗi ký tự',

            'role_name.required' => 'Vui lòng điền :attribute',
            'role_name.max' => ':Attribute tối đa :max ký tự',
            'role_name.string' => ':Attribute dạng chuỗi ký tự',

            'avatar.required' => 'Vui lòng chọn :attribute',
            'avatar.mimes' => ':Attribute có định dạng jpeg, png, jpg',
            'avatar.max' => ':Attribute không quá 10MB',

            'birthday.required' => 'Vui lòng điền :attribute',
            'birthday.date_format' => ':Attribute có định dạng yyyy-mm-dd',

            'leaveday.date_format' => ':Attribute có định dạng yyyy-mm-dd',

            'address.string' => ':Attribute dạng chuỗi ký tự',
            'address.max' => ':Attribute tối đa :max ký tự',

            'email.email' => ':Attribute sai định dạng',
            'email.max' => ':Attribute tối đa :max ký tự',

            'phone.digits_between' => ':Attribute từ :digits_between ký tự',

            'gender.required' => 'Vui lòng điền :attribute',
            'gender.digits_between' => ':Attribute trong phạm vi [:digits_between]',

            'story.string' => ':Attribute dạng chuỗi ký tự',
        ];
    }

    public function attributes()
    {
        return [
            'fullname' => 'họ tên',
            'role_name' => 'vai trò',
            'avatar' => 'ảnh đại diện',
            'birthday' => 'ngày sinh',
            'leaveday' => 'ngày mất',
            'address' => 'địa chỉ',
            'email' => 'email',
            'phone' => 'số điện thoại',
            'gender' => 'giới tính',
            'story' => 'tiểu sử',
        ];
    }
}
