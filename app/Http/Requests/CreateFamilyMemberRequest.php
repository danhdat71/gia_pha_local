<?php

namespace App\Http\Requests;

use App\Constants\Relation;
use Illuminate\Foundation\Http\FormRequest;

class CreateFamilyMemberRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'relation' => ['required', 'digits_between:1,2'],
            'fullname' => ['required', 'max:200', 'string'],
            'role_name' => ['required', 'max:200', 'string'],
            'avatar' => ['nullable', 'mimes:jpeg,png,jpg', 'max:10000'], // 10mb,
            'avatar_name' => ['nullable', 'string', 'max:255'],
            'cccd_number' => ['nullable', 'digits_between:10,50', 'numeric', 'unique:users,cccd_number'],

            'cccd_image_before' =>  ['nullable', 'mimes:jpeg,png,jpg', 'max:10000'],
            'cccd_image_before_name' =>  ['nullable', 'string', 'max:255'],

            'cccd_image_after' =>  ['nullable', 'mimes:jpeg,png,jpg', 'max:10000'],
            'cccd_image_after_name' =>  ['nullable', 'string', 'max:255'],

            'born_day' => ['nullable', 'integer', 'min:1', 'max:31'],
            'born_month' => ['nullable', 'integer', 'min:1', 'max:12'],
            'born_year' => ['nullable', 'integer', 'min:1111', 'max:9999'],

            'leave_day' => ['nullable', 'integer', 'min:1', 'max:31'],
            'leave_month' => ['nullable', 'integer', 'min:1', 'max:12'],
            'leave_year' => ['nullable', 'integer', 'min:1111', 'max:9999'],

            'address' => ['nullable', 'max:200', 'string'],
            'domicile' => ['nullable', 'max:200', 'string'],
            'email' => ['required', 'email', 'max:200', 'unique:users,email'],
            'phone' => ['nullable', 'digits_between:8,13'],
            'story' => ['nullable', 'string'],
            'mid' => ['nullable', 'numeric'],
            'fid' => ['nullable', 'numeric'],

            'job' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'organization' => ['nullable', 'string', 'max:255'],

            'cert_images' => ['nullable', 'array', 'max:10'],
            'cert_images.*' => ['mimes:jpeg,png,jpg', 'max:10000'],
            'cert_image_names' => ['nullable', 'string'],

            'rest_place' => ['nullable', 'string', 'max:255'],
            'lat' => ['nullable', 'numeric', 'min:-90', 'max:90'],
            'long' => ['nullable', 'numeric', 'min:-90', 'max:90'],

            'rest_images' => ['nullable', 'array', 'max:10'],
            'rest_images.*' => ['mimes:jpeg,png,jpg', 'max:10000'],
            'rest_image_names' => ['nullable', 'string'],

            'video_360_url' => ['nullable', 'mimes:mp4,mov', 'max:50000'],
        ];

        if (request()->avatar_name) {
            $rules['avatar'] = ['nullable', 'mimes:jpeg,png,jpg', 'max:10000'];
        }
        if (request()->cccd_image_before_url) {
            $rules['cccd_image_before'] = ['nullable', 'mimes:jpeg,png,jpg', 'max:10000'];
        }
        if (request()->cccd_image_after_url) {
            $rules['cccd_image_after'] = ['nullable', 'mimes:jpeg,png,jpg', 'max:10000'];
        }

        if (request()->relation == Relation::CHILD) {
            $rules['position_index'] = ['required', 'numeric', 'min:1'];
            $rules['gender'] = ['required', 'digits_between: 1,2'];
        } else if (request()->relation == Relation::COUPLE) {
            $rules['from_member_id'] = ['required', 'numeric'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'relation.required' => 'Vui lòng điền :attribute',
            'relation.digits_between' => ':Attribute từ :digits_between ký tự',
            
            'fullname.required' => 'Vui lòng điền :attribute',
            'fullname.max' => ':Attribute tối đa :max ký tự',
            'fullname.string' => ':Attribute dạng chuỗi ký tự',

            'role_name.required' => 'Vui lòng điền :attribute',
            'role_name.max' => ':Attribute tối đa :max ký tự',
            'role_name.string' => ':Attribute dạng chuỗi ký tự',

            'avatar.mimes' => ':Attribute có định dạng jpeg, png, jpg',
            'avatar.max' => ':Attribute không quá 10MB',

            'cccd_number.required' => 'Vui lòng điền :attribute',
            'cccd_number.digits_between' => ':Attribute tối đa 10-50 ký tự',
            'cccd_number.numeric' => ':Attribute là kiểu số',
            'cccd_number.unique' => ':Attribute đã tồn tại',

            'cccd_image_before.required' => 'Vui lòng chọn :attribute',
            'cccd_image_before.mimes' => ':Attribute định dạng jpeg,png,jpg',
            'cccd_image_before.max' => ':Attribute tối đa 10MB',

            'cccd_image_after.required' => 'Vui lòng chọn :attribute',
            'cccd_image_after.mimes' => ':Attribute định dạng jpeg,png,jpg',
            'cccd_image_after.max' => ':Attribute tối đa 10MB',

            'born_day.integer' => ':Attribute sai định dạng',
            'born_day.min' => ':Attribute sai định dạng',
            'born_day.max' => ':Attribute sai định dạng',

            'born_month.integer' => ':Attribute sai định dạng',
            'born_month.min' => ':Attribute sai định dạng',
            'born_month.max' => ':Attribute sai định dạng',

            'born_year.integer' => ':Attribute sai định dạng',
            'born_year.min' => ':Attribute sai định dạng',
            'born_year.max' => ':Attribute sai định dạng',

            'leave_day.integer' => ':Attribute sai định dạng',
            'leave_day.min' => ':Attribute sai định dạng',
            'leave_day.max' => ':Attribute sai định dạng',

            'leave_month.integer' => ':Attribute sai định dạng',
            'leave_month.min' => ':Attribute sai định dạng',
            'leave_month.max' => ':Attribute sai định dạng',

            'leave_year.integer' => ':Attribute sai định dạng',
            'leave_year.min' => ':Attribute sai định dạng',
            'leave_year.max' => ':Attribute sai định dạng',

            'address.string' => ':Attribute dạng chuỗi ký tự',
            'address.max' => ':Attribute tối đa :max ký tự',

            'domicile.string' => ':Attribute dạng chuỗi ký tự',
            'domicile.max' => ':Attribute tối đa :max ký tự',

            'email.email' => ':Attribute sai định dạng',
            'email.max' => ':Attribute tối đa :max ký tự',
            'email.required' => 'Vui lòng điền :attribute',
            'email.unique' => ':Attribute đã tồn tại, vui lòng điền email khác',

            'phone.digits_between' => ':Attribute từ [8-13] ký tự',

            'gender.required' => 'Vui lòng điền :attribute',
            'gender.digits_between' => ':Attribute trong phạm vi [:digits_between]',

            'story.string' => ':Attribute dạng chuỗi ký tự',

            'position_index.required' => 'Vui lòng điền :attribute',
            'position_index.numeric' => ':Attribute phải là dạng số',
            'position_index.min' => ':Attribute tối thiểu là :min',

            'pids.required' => 'Vui lòng điền :attribute',
            'pids.numeric' => ':Attribute phải là dạng số',

            'mid.required' => 'Vui lòng điền :attribute',
            'mid.numeric' => ':Attribute phải là dạng số',

            'fid.required' => 'Vui lòng điền :attribute',
            'fid.numeric' => ':Attribute phải là dạng số',

            'job.string' => ':Attribute dạng chuỗi ký tự',
            'job.max' => ':Attribute tối đa :max ký tự',

            'position.string' => ':Attribute dạng chuỗi ký tự',
            'position.max' => ':Attribute tối đa :max ký tự',

            'organization.string' => ':Attribute dạng chuỗi ký tự',
            'organization.max' => ':Attribute tối đa :max ký tự',

            'cert_images.array' => ':Attribute dạng mảng',
            'cert_images.max' => ':Attribute tối đa :max ảnh',
            'cert_images.*.mimes' => ':Attribute định dạng jpeg,png,jpg',
            'cert_images.*.max' => ':Attribute tối đa 10MB',

            'rest_place.string' => ':Attribute dạng chuỗi ký tự',
            'rest_place.max' => ':Attribute tối đa :max ký tự',

            'lat.numeric' => ':Attribute dạng số',
            'lat.min' => ':Attribute tối thiểu :min',
            'lat.max' => ':Attribute tối đa :max',

            'long.numeric' => ':Attribute dạng số',
            'long.min' => ':Attribute tối thiểu :min',
            'long.max' => ':Attribute tối đa :max',

            'rest_images.array' => ':Attribute dạng mảng',
            'rest_images.max' => ':Attribute tối đa :max ảnh',
            'rest_images.*.mimes' => ':Attribute định dạng jpeg,png,jpg',
            'rest_images.*.max' => ':Attribute tối đa 10MB',

            'video_360_url.mimes' => ':Attribute có định dạng mp4, mov',
            'video_360_url.max' => ':Attribute không quá 50MB',
        ];
    }

    public function attributes()
    {
        return [
            'relation' => 'mối quan hệ',
            'fullname' => 'họ tên',
            'role_name' => 'vai trò',
            'avatar' => 'ảnh đại diện',
            'born_day' => 'ngày sinh',
            'born_month' => 'tháng sinh',
            'born_year' => 'năm sinh',
            'leave_day' => 'ngày mất',
            'leave_month' => 'tháng mất',
            'leave_year' => 'năm mất',
            'address' => 'địa chỉ',
            'email' => 'email',
            'phone' => 'số điện thoại',
            'gender' => 'giới tính',
            'story' => 'tiểu sử',
            'position_index' => 'vị trí con cái',
            'pids' => 'id vợ hoặc chồng',
            'mid' => 'id của mẹ',
            'fid' => 'id của cha',
            'cccd_number' => 'mã cccd',
            'cccd_image_before' => 'ảnh mặt trước cccd',
            'cccd_image_after' => 'ảnh mặt sau cccd',
            'domicile' => 'nguyên quán',
            'job' => 'nghề nghiệp / chuyên môn',
            'position' => 'chức vụ',
            'organization' => 'tổ chức',
            'cert_images' => 'hình ảnh chứng chỉ',
            'cert_images.*' => 'ảnh chứng chỉ',
            'rest_place' => 'nơi an nghỉ',
            'lat' => 'latitude',
            'long' => 'longitude',
            'rest_images' => 'hình ảnh an nghỉ',
            'rest_images.*' => 'ảnh an nghỉ',
            'video_360_url' => 'video 360 độ',
        ];
    }
}
