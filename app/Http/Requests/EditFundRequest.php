<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditFundRequest extends FormRequest
{
    public function rules()
    {
        return [
            'description' => ['required', 'string', 'max:5000'],
            'fund_type' => ['required', 'numeric', 'min:1', 'max:2'],
            'event_id' => ['nullable', 'numeric', 'exists:events,id'],
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

            'fund_type.required' => 'Vui lòng chọn :attribute',
            'fund_type.numeric' => ':Atrribute dạng số',
            'fund_type.min' => ':Atrribute tối thiểu :min',
            'fund_type.max' => ':Atrribute tối đa :max',

            'event_id.numeric' => ':Attribute dạng số',
            'event_id.exists' => ':attribute không tồn tại',

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
            'fund_type' => 'loại thu chi',
            'event_id' => 'id sự kiện',
            'date' => 'ngày tạo',
            'proof' => 'ảnh minh chứng'
        ];
    }
}
