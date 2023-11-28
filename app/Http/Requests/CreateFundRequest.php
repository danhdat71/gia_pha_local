<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFundRequest extends FormRequest
{
    public function rules()
    {
        return [
            'description' => ['required', 'string', 'max:5000'],
            'user_id' => ['nullable', 'numeric', 'exists:users,id'],
            'event_id' => ['nullable', 'numeric', 'exists:events,id'],
            'fund_type' => ['required', 'numeric', 'min:1', 'max:2'],
            'date' => ['required', 'date_format:Y-m-d'],
            'proof' => ['nullable', 'max:10240', 'mimes:jpg,png'],
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'Vui lòng điền :attribute',
            'description.string' => ':Attribute dạng chuỗi ký tự',
            'description.max' => ':Attribute tối đa :max ký tự',

            'user_id.required' => 'Vui lòng chọn :attribute',
            'user_id.numeric' => ':Attribute dạng số',
            'user_id.exists' => ':Attribute không tồn tại',

            'event_id.numeric' => ':Attribute dạng số',
            'event_id.exists' => ':attribute không tồn tại',

            'fund_type.required' => 'Vui lòng chọn :attribute',
            'fund_type.numeric' => ':attribute dạng số',
            'fund_type.min' => ':Attribute tối thiểu :min',
            'fund_type.max' => ':attribute tối đa :max',

            'date.required' => 'Vui lòng chọn :attribute',
            'date.format' => ':Attribute định dạng Y-m-d',

            'proof.max' => ':Attribute tối đa 10MB',
            'proof.mimes' => ':Attribute dạng jpg,png',
        ];
    }

    public function attributes()
    {
        return [
            'description' => 'mô tả thu chi',
            'user_id' => 'id user',
            'event_id' => 'id sự kiện',
            'fund_type' => 'loại thu chi',
            'date' => 'ngày tạo',
            'proof' => 'ảnh minh chứng'
        ];
    }
}
