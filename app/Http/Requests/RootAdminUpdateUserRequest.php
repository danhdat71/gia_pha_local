<?php

namespace App\Http\Requests;

use App\Constants\Trial;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class RootAdminUpdateUserRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'full_name' => ['required', 'max:255'],
            'born_day' => ['nullable', 'integer', 'min:1', 'max:31'],
            'born_month' => ['nullable', 'integer', 'min:1', 'max:12'],
            'born_year' => ['nullable', 'integer', 'min:1111', 'max:9999'],
            'title' => ['required', 'max:255'],
            'gender' => ['required'],
            'pass' => ['nullable', 'string', 'min:8', 'max:200'],
            'domain' => ['nullable', 'string', 'max:255'],
            'template_id' => ['required', 'digits_between:1,4'],
            'trial_month' => ['nullable', 'in:' . implode(',', Trial::TRIAL_MONTHS)],
            'max_member_trial' => ['nullable', 'in:' . implode(',', Trial::TRIAL_MEMBERS)],
        ];

        $familyTreeDomain = User::find(request()->id)->familyTree->domain;
        if (request()->domain != $familyTreeDomain) {
            $rules['domain'] = ['nullable', 'string', 'max:255', 'unique:family_trees,domain'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
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

            'trial_month.in' => ':Attribute có giá trị 3 hoặc 6',
            'max_member_trial.in' => ':Attribute có giá trị 10, 20 hoặc 30',
        ];
    }

    public function attributes()
    {
        return [
            'full_name' => 'họ tên',
            'born_day' => 'ngày sinh',
            'born_month' => 'tháng sinh',
            'born_year' => 'năm sinh',
            'title' => 'tiêu đề gia phả',
            'gender' => 'giới tính',
            'pass' => 'mật khẩu',
            'domain' => 'tên miền',
            'trial_month' => 'hạn dùng thử',
            'max_member_trial' => 'giới hạn thành viên',
        ];
    }
}
