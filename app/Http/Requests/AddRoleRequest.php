<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\UserType;

class AddRoleRequest extends FormRequest
{
    public function rules()
    {
        $admins = [
            UserType::FAMILY_ADMIN,
            UserType::FAMILY_SUB_ADMIN,
            UserType::SECRETARY,
        ];
        return [
            'user_id' => ['required', 'exists:users,id'],
            'type' => ['required', 'in:' . implode(',', $admins)],
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Vui lòng nhập :attribute',
            'user_id.exists' => ':Attribute không tồn tại',

            'type.required' => ':Attribute không tồn tại',
            'type.in' => ':Attribute không tồn tại',
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => 'id người dùng',
            'type' => 'id vai trò',
        ];
    }
}
