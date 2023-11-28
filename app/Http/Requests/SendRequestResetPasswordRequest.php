<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendRequestResetPasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'max:255', 'exists:users,email'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Vui lòng điền :attribute',
            'email.email' => ':Attribute định dạng email',
            'email.max' => ':Attribute tối đa :max ký tự',
            'email.exists' => ':Attribute không tồn tại',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'địa chỉ email',
        ];
    }
}
