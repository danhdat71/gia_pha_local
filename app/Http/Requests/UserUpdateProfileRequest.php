<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateProfileRequest extends FormRequest
{
    public function rules()
    {
        return [
            'full_name' => ['nullable', 'min:1', 'max:200', 'string'],
            'role_name' => ['nullable', 'max:200', 'string'],
            'avatar' => ['nullable', 'mimes:jpeg,png,jpg', 'max:10000'], // 10mb
            'born_day' => ['nullable', 'integer', 'min:1', 'max:31'],
            'born_month' => ['nullable', 'integer', 'min:1', 'max:12'],
            'born_year' => ['nullable', 'integer', 'min:1111', 'max:9999'],
            'leaveday' => ['nullable', 'date_format:Y-m-d'],
            'address' => ['nullable', 'max:200', 'string'],
            'domicile' => ['nullable', 'max:200', 'string'],
            'phone' => ['nullable', 'digits_between:8,13'],
            'story' => ['nullable', 'string'],
            'job' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'organization' => ['nullable', 'string', 'max:255'],
            'rest_place' => ['nullable', 'string', 'max:255'],
            'cccd_number' => ['nullable', 'digits_between:10,50', 'numeric', 'unique:users,cccd_number'],
        ];
    }

    public function messages()
    {
        return [
            'full_name.min' => ':Attribute tối thiểu :min ký tự',
            'full_name.max' => ':Attribute tối đa :max ký tự',
            'full_name.string' => ':Attribute dạng chuỗi ký tự',

            'role_name.max' => ':Attribute tối đa :max ký tự',
            'role_name.string' => ':Attribute dạng chuỗi ký tự',

            'avatar.mimes' => ':Attribute có định dạng jpeg, png, jpg',
            'avatar.max' => ':Attribute không quá 10MB',

            'born_day.integer' => ':Attribute sai định dạng',
            'born_day.min' => ':Attribute sai định dạng',
            'born_day.max' => ':Attribute sai định dạng',

            'born_month.integer' => ':Attribute sai định dạng',
            'born_month.min' => ':Attribute sai định dạng',
            'born_month.max' => ':Attribute sai định dạng',

            'born_year.integer' => ':Attribute sai định dạng',
            'born_year.min' => ':Attribute sai định dạng',
            'born_year.max' => ':Attribute sai định dạng',

            'leaveday.date_format' => ':Attribute có định dạng yyyy-mm-dd',

            'address.string' => ':Attribute dạng chuỗi ký tự',
            'address.max' => ':Attribute tối đa :max ký tự',

            'domicile.string' => ':Attribute dạng chuỗi ký tự',
            'domicile.max' => ':Attribute tối đa :max ký tự',

            'phone.digits_between' => ':Attribute từ [8~13] ký tự',

            'story.string' => ':Attribute dạng chuỗi ký tự',

            'job.string' => ':Attribute dạng chuỗi ký tự',
            'job.max' => ':Attribute tối đa :max ký tự',

            'position.string' => ':Attribute dạng chuỗi ký tự',
            'position.max' => ':Attribute tối đa :max ký tự',

            'organization.string' => ':Attribute dạng chuỗi ký tự',
            'organization.max' => ':Attribute tối đa :max ký tự',

            'rest_place.string' => ':Attribute dạng chuỗi ký tự',
            'rest_place.max' => ':Attribute tối đa :max ký tự',

            'lat.numeric' => ':Attribute dạng số',
            'lat.min' => ':Attribute tối thiểu :min',
            'lat.max' => ':Attribute tối đa :max',

            'long.numeric' => ':Attribute dạng số',
            'long.min' => ':Attribute tối thiểu :min',
            'long.max' => ':Attribute tối đa :max',

            'cccd_number.required' => 'Vui lòng điền :attribute',
            'cccd_number.digits_between' => ':Attribute tối đa 10-50 ký tự',
            'cccd_number.numeric' => ':Attribute là kiểu số',
            'cccd_number.unique' => ':Attribute đã tồn tại',
        ];
    }

    public function attributes()
    {
        return [
            'full_name' => 'họ tên',
            'role_name' => 'vai trò',
            'avatar' => 'ảnh đại diện',
            'born_day' => 'ngày sinh',
            'born_month' => 'tháng sinh',
            'born_year' => 'năm sinh',
            'leaveday' => 'ngày mất',
            'address' => 'địa chỉ',
            'email' => 'email',
            'phone' => 'số điện thoại',
            'story' => 'tiểu sử',
            'domicile' => 'nguyên quán',
            'job' => 'nghề nghiệp / chuyên môn',
            'position' => 'chức vụ',
            'organization' => 'tổ chức',
            'rest_place' => 'nơi an nghỉ',
            'lat' => 'latitude',
            'long' => 'longitude',
            'cccd_number' => 'mã cccd',
        ];
    }
}
