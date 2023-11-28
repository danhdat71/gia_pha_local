<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditBlogRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'mimes:jpeg,png,jpg', 'max:10000'], // 10mb,
            'is_visible' => ['required', 'numeric', 'min:0', 'max:1'],
            'content' => ['nullable', 'string'],
        ];
    }
    
    public function messages()
    {
        return [
            'title.required' => 'Vui lòng điền :attribute',
            'title.string' => ':Attribute dạng chuỗi ký tự',
            'title.max' => ':Attribute tối đa :max ký tự',

            'avatar.mimes' => ':Attribute định dạng jpeg,png,jpg',
            'avatar.max' => ':Attribute tối đa 10MB',

            'is_visible.required' => 'Vui lòng chọn :attribute',
            'is_visible.numeric' => ':Attribute dạng số',
            'is_visible.min' => ':Attribute tối thiểu :min',
            'is_visible.max' => ':Attribute tối đa :max',

            'content.string' => ':Attribute dạng chuỗi ký tự',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'tiêu đề bài viết',
            'avatar' => 'ảnh bài viết',
            'is_visible' => 'trạng thái hiển thị',
            'content' => 'nội dung bài viết',
        ];
    }
}
