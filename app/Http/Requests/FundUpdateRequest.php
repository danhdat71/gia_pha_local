<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FundUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'description' => ['required', 'string', 'max:5000'],
            'event_id' => ['nullable', 'numeric', 'exists:events,id'],
            'fund_type' => ['required', 'numeric', 'min:1', 'max:2'],
            'date' => ['required', 'date_format:Y-m-d'],
            'proof' => ['nullable', 'mimes:jpg,png,jpeg', 'max:10240'],
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'Vui lòng điền :attribute',
            'description.string' => ':Attribute dạng chuỗi ký tự',
            'description.max' => ':Attribute tối đa :max ký tự',

            'event_id.numeric' => ':Attribute dạng số',
            'event_id.exists' => ':attribute không tồn tại',

            'fund_type.required' => 'Vui lòng chọn :attribute',
            'fund_type.numeric' => ':attribute dạng số',
            'fund_type.min' => ':Attribute tối thiểu :min',
            'fund_type.max' => ':attribute tối đa :max',

            'date.required' => 'Vui lòng chọn :attribute',
            'date.format' => ':Attribute định dạng Y-m-d',

            'proof.mimes' => ':Attribute định dạng jpg,png,jpeg.',
            'proof.max' => ':Attribute tối đa 10MB.',
        ];
    }

    public function attributes()
    {
        return [
            'description' => 'mô tả thu chi',
            'event_id' => 'id sự kiện',
            'fund_type' => 'loại thu chi',
            'date' => 'ngày tạo',
            'proof' => 'ảnh minh chứng',
        ];
    }
}
