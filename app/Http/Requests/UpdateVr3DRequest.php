<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVr3DRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required', 'max:255'],
            'vr_3d_file' => ['nullable', 'max:102400'],
            'buttons' => ['nullable', 'array'],
            'buttons.*.title' => ['required', 'max:50'],
            'buttons.*.button_x' => ['required', 'numeric', 'min:-100', 'max:100'],
            'buttons.*.button_y' => ['required', 'numeric', 'min:-100', 'max:100'],
            'buttons.*.button_z' => ['required', 'numeric', 'min:-100', 'max:100'],
            'buttons.*.to_vr_3d_id' => ['required', ], //'exists:vr_3ds,id'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Vui lòng điền :attribute',
            'title.max' => ':Attribute tối đa :max ký tự',

            'vr_3d_file.required' => 'Vui lòng chọn :attribute',
            'vr_3d_file.mimes' => ':Attribute định dạng glb, gltf',
            'vr_3d_file.max' => ':Attribute tối đa 100MB',

            'buttons.*.title.required' => ':Attribute không được bỏ trống',
            'buttons.*.title.max' => ':Attribute tối đa :max ký tự',

            'buttons.*.button_x.required' => ':Attribute không được bỏ trống',
            'buttons.*.button_x.numeric' => ':Attribute phải là dạng số',
            'buttons.*.button_x.min' => ':Attribute có giá trị tối thiểu :min',
            'buttons.*.button_x.max' => ':Attribute có giá trị tối đa :max',

            'buttons.*.button_y.required' => ':Attribute không được bỏ trống',
            'buttons.*.button_y.numeric' => ':Attribute phải là dạng số',
            'buttons.*.button_y.min' => ':Attribute có giá trị tối thiểu :min',
            'buttons.*.button_y.max' => ':Attribute có giá trị tối đa :max',

            'buttons.*.button_z.required' => ':Attribute không được bỏ trống',
            'buttons.*.button_z.numeric' => ':Attribute phải là dạng số',
            'buttons.*.button_z.min' => ':Attribute có giá trị tối thiểu :min',
            'buttons.*.button_z.max' => ':Attribute có giá trị tối đa :max',

            'buttons.*.to_vr_3d_id.required' => ':Attribute không được bỏ trống',
            'buttons.*.to_vr_3d_id.exists' => ':Attribute không tồn tại',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'tiêu đề ngữ cảnh',
            'vr_3d_file' => 'file ngữ cảnh 3D',
            'buttons' => 'nút',
            'buttons.*.title' => 'tiêu đề nút',
            'buttons.*.button_x' => 'tọa độ x',
            'buttons.*.button_y' => 'tọa độ y',
            'buttons.*.button_z' => 'tọa độ z',
            'buttons.*.to_vr_3d_id' => 'id vr 3d',
        ];
    }
}
