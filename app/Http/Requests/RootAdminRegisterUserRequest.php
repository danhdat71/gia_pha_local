<?php

namespace App\Http\Requests;

use App\Constants\Trial;
use Illuminate\Foundation\Http\FormRequest;

class RootAdminRegisterUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'full_name' => ['required', 'max:255'],
            'born_day' => ['nullable', 'integer', 'min:1', 'max:31'],
            'born_month' => ['nullable', 'integer', 'min:1', 'max:12'],
            'born_year' => ['nullable', 'integer', 'min:1111', 'max:9999'],
            'title' => ['required', 'max:255'],
            'gender' => ['required'],
            'pass' => ['required', 'string', 'min:8', 'max:200'],
            'domain' => ['nullable', 'string', 'max:255', 'unique:family_trees,domain'],
            'template_id' => ['required', 'digits_between:1,4'],
            'trial_month' => ['required', 'in:' . implode(',', Trial::TRIAL_MONTHS)],
            'trial_member' => ['required', 'in:' . implode(',', Trial::TRIAL_MEMBERS)],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Vui lòng điền :attribute',
            'email.email' => ':Attribute định dạng email',
            'email.max' => ':Attribute tối đa :max ký tự',
            'email.unique' => ':Attribute đã tồn tại',

            'full_name.required' => 'Vui lòng điền :attribute',
            'full_name.max' => ':Attribute tối đa :max ký tự',

            'born_day.integer' => ':Attribute sai định dạng',
            'born_day.min' => ':Attribute sai định dạng',
            'born_day.max' => ':Attribute sai định dạng',

            'born_month.integer' => ':Attribute sai định dạng',
            'born_month.min' => ':Attribute sai định dạng',
            'born_month.max' => ':Attribute sai định dạng',

            'born_year.integer' => ':Attribute sai định dạng',
            'born_year.min' => ':Attribute sai định dạng',
            'born_year.max' => ':Attribute sai định dạng',

            'title.required' => 'Vui lòng điền :attribute',
            'title.max' => ':Attribute tối đa :max ký tự',

            'gender.required' => 'Vui lòng chọn :attribute',
            'gender.numeric' => ':Attribute sai định dạng',

            'pass.required' => 'Vui lòng nhập :attribute',
            'pass.string' => ':Attribute là dạng chuỗi',
            'pass.min' => ':Attribute tối thiểu :min ký tự',
            'pass.max' => ':Attribute tối đa :max ký tự',

            'domain.string' => ':Attribute là chuỗi ký tự',
            'domain.max' => ':Attribute tối đa :max ký tự',
            'domain.unique' => ':Attribute đã tồn tại',

            'trial_month.required' => 'Vui lòng nhập :attribute',
            'trial_month.in' => ':Attribute là 3 hoặc 6 tháng',

            'trial_member.required' => 'Vui lòng nhập :attribute',
            'trial_member.in' => ':Attribute là 10, 20 hoặc 30 tháng',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'địa chỉ email',
            'full_name' => 'họ tên',
            'born_day' => 'ngày sinh',
            'born_month' => 'tháng sinh',
            'born_year' => 'năm sinh',
            'title' => 'tiêu đề gia phả',
            'gender' => 'giới tính',
            'pass' => 'mật khẩu',
            'domain' => 'tên miền',
            'trial_month' => 'thời hạn dùng thử',
            'trial_member' => 'giới hạn thành viên',
        ];
    }
}
