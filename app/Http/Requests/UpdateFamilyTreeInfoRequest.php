<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFamilyTreeInfoRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required', 'max:255'],
            'description' => ['nullable', 'string'],
            'audio_link' => ['nullable', 'mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Vui lòng điền :attribute',
            'title.max' => ':Attribute tối đa :max ký tự',
            'description.required' => 'Vui lòng điền :attribute',
            'description.string' => ':Attribute dạng chuỗi ký tự',
            'audio_link.mimes' => ':Attribute sai định dạng',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'tên gia phả',
            'description' => 'mô tả gia phả',
            'audio_link' => 'nhạc nền',
        ];
    }
}
