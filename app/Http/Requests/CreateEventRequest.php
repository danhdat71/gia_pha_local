<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'title' => ['required', 'max:200', 'string'],
            'date' => ['required', 'date_format:Y-m-d', 'after:today'],
            'description' => ['required', 'string', 'max:255'],
            'event_times' => ['array', 'required'],
            'event_times.*.start_at' => ['required', 'date_format:H:i'],
            'event_times.*.end_at' => ['required', 'date_format:H:i', 'after:event_times.*.start_at'],
            'event_times.*.description' => ['required', 'string', 'max:500'],
            'join_members' => ['required', 'string'],
            'detail' => ['nullable', 'string'],
            'is_year_loop' => ['required', 'numeric', 'min:0', 'max:1'],
            'noti_day_before' => ['nullable', 'numeric', 'min:1', 'max:99'],
            'noti_time_before' => ['nullable', 'date_format:H:i'],
        ];

        if (request()->is_year_loop)
        {
            $rules['noti_day_before'] = ['required', 'numeric', 'min:1', 'max:99'];
            $rules['noti_time_before'] = ['required', 'date_format:H:i'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'Vui lòng điền :attribute',
            'title.max' => ':Attribute tối đa :max ký tự',
            'title.string' => ':Attribute là kiểu chuỗi ký tự',

            'date.required' => 'Vui lòng chọn :attribute',
            'date.date_format' => ':Attribute kiểu year-month-day',
            'date.after' => ':Attribute sau ngày hôm nay',

            'description.required' => 'Vui lòng điền vài thông tin :attribute',
            'description.max' => 'Vui lòng điền vài thông tin :attribute',
            'description.string' => 'Vui lòng điền vài thông tin :attribute',

            'event_times.array' => ':Attribute là kiểu mảng',
            'event_times.required' => 'Vui lòng thêm :attribute',
            'event_times.*.start_at.required' => 'Vui lòng chọn :attribute',
            'event_times.*.start_at.date_format' => ':Attribute kiểu giờ:phút',
            'event_times.*.end_at.required' => 'Vui lòng chọn :attribute',
            'event_times.*.end_at.date_format' => ':Attribute kiểu giờ:phút',
            'event_times.*.end_at.after' => ':Attribute phải sau thời gian bắt đầu',
            'event_times.*.description.required' => 'Vui lòng điền :attribute',
            'event_times.*.description.string' => ':Attribute kiểu chuỗi',
            'event_times.*.description.max' => ':Attribute tối đa :max ký tự',

            'join_members.required' => 'Vui lòng chọn :attribute',
            'join_members.string' => ':Attribute là kiểu chuỗi ký tự',

            'detail.string' => ':Attribute là kiểu chuỗi ký tự',

            'is_year_loop.required' => 'Vui lòng thêm :attribute',
            'is_year_loop.numeric' => ':Attribute là kiểu số',
            'is_year_loop.min' => ':Attribute tối thiểu là :min',
            'is_year_loop.max' => ':Attribute tối đa là :max',

            'noti_day_before.required' => 'Vui lòng điền :attribute',
            'noti_day_before.numeric' => ':Attribute là kiểu số',
            'noti_day_before.min' => ':Attribute tối thiểu là :min',
            'noti_day_before.max' => ':Attribute tối đa là :max',

            'noti_time_before.required' => 'Vui lòng điền :attribute',
            'noti_time_before.date_format' => ':Attribute kiểu giờ:phút',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'tiêu đề sự kiện',
            'date' => 'ngày sự kiện',
            'description' => 'mô tả ngắn',
            'event_times' => 'thời gian sự kiện',
            'start_at' => 'thời gian bắt đầu',
            'end_at' => 'thời gian kết thúc',
            'event_times.*.start_at' => 'thời gian bắt đầu',
            'event_times.*.end_at' => 'thời gian kết thúc',
            'event_times.*.description' => 'mô tả thời gian',
            'join_members' => 'thành viên tham gia',
            'detail' => 'chi tiết sự kiện',
            'is_year_loop' => 'lặp hằng năm',
            'noti_day_before' => 'số ngày thông báo trước',
            'noti_time_before' => 'thời điểm thông báo',
        ];
    }
}
