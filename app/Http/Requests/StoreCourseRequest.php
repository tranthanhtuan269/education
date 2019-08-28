<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image'             => 'required',
            'name'              => 'required|max:255',
            'short_description' => 'required|max:255',
            'description'       => 'required',
            'will_learn'        => 'required',
            // 'requirement'       => 'required|max:255',
            'price'             => 'required|numeric',
            'approx_time'       => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'image.required'            => 'Bạn chưa chọn ảnh cho khóa học.',
            'name.required'             => 'Bạn chưa nhập tên khóa học.',
            'name.max'                  => 'Tên khóa học quá dài.',

            'short_description.required'=> 'Bạn chưa nhập Tóm tắt.',
            'short_description.max'     => 'Tóm tắt quá dài.',
            'description.required'      => 'Bạn chưa nhập Mô tả.',

            'will_learn.required'       => 'Bạn chưa nhập Học viên sẽ học được gì.',

            'price.required'            => 'Bạn chưa nhập giá khóa học.',
            'price.numeric'             => 'Giá khóa học phải là số.',

            'approx_time.required'      => 'Bạn chưa nhập Thời gian ước tính.',
            'approx_time.numeric'       => 'Thời gian ước tính phải là số.',
        ];
    }
}
