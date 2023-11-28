<?php

namespace App\Http\Requests;

use App\Constants\Gender;
use App\Rules\PreventEmailRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email', new PreventEmailRule],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'gender' => ['required', 'numeric', 'in:' . implode(',', [Gender::MALE, Gender::FEMALE])],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Vui lòng cung cấp :attribute',
            'title.string' => ':Attribute sai định dạng',
            'title.max' => ':Attribute tối đa :max ký tự',

            'full_name.required' => 'Vui lòng cung cấp :attribute',
            'full_name.string' => ':Attribute sai định dạng',
            'full_name.max' => ':Attribute tối đa :max ký tự',

            'email.required' => 'Vui lòng cung cấp :attribute',
            'email.email' => 'Vui lòng cung cấp :attribute',
            'email.max' => 'Vui lòng cung cấp :attribute',
            'email.unique' => ':Attribute đã tồn tại',

            'birthday.required' => 'Vui lòng cung cấp :attribute',
            'birthday.date_format' => ':Attribute sai định dạng',

            'gender.required' => 'Vui lòng cung cấp :attribute',
            'gender.numeric' => ':Attribute đã tồn tại',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'tên gia phả',
            'full_name' => 'họ và tên',
            'email' => 'địa chỉ email',
            'birthday' => 'sinh nhật',
            'gender' => 'giới tính',
        ];
    }
}