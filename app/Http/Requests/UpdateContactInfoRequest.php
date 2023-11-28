<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactInfoRequest extends FormRequest
{
    public function rules()
    {
        return [
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'phone.string' => ':Attribute dạng chuỗi ký tự',
            'phone.max' => ':Attribute tối đa :max ký tự',

            'email.email' => ':Attribute sai định dạng',
            'email.max' => ':Attribute tối đa :max ký tự',

            'contact_person.string' => ':Attribute dạng chuỗi ký tự',
            'contact_person.max' => ':Attribute tối đa :max ký tự',

            'position.string' => ':Attribute dạng chuỗi ký tự',
            'position.max' => ':Attribute tối đa :max ký tự',

            'address.string' => ':Attribute dạng chuỗi ký tự',
            'address.max' => ':Attribute tối đa :max ký tự',
        ];
    }

    public function attributes()
    {
        return [
            'phone' => 'số điện thoại',
            'email' => 'địa chỉ email',
            'contact_person' => 'người liên hệ',
            'position' => 'chức vụ',
            'address' => 'địa chỉ',
        ];
    }
}
