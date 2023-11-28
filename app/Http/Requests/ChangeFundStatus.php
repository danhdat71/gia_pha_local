<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeFundStatus extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required', 'exists:funds,id'],
            'status' => ['required', 'numeric', 'min:0', 'max:1'],
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Vui lòng cung cấp :attribute', 
            'id.exists' => ':Attribute không tồn tại',

            'status.required' => 'Vui lòng cung cấp :attribute',
            'status.numeric' => ':Attribute dạng numeric',
            'status.min' => ':Attribute tối thiểu :min',
            'status.max' => ':Attribute tối đa :max',
        ];
    }
}
