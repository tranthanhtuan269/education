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
            'name'              => 'required|min:3|max:255',
            'short_description' => 'required|max:255',
            'description'       => 'required',
            'will_learn'        => 'required',
            'requirement'       => 'required',
            'original_price'    => 'required|numeric|min:0',
            'discount_price'    => 'numeric|min:0',
            'approx_time'       => 'required|numeric|min:0|max:999',
            'link_intro'        => 'required',
        ];
    }

    public function messages()
    {
        return [
            'image.required'            => 'Bạn chưa chọn Ảnh khóa học.',

            'name.required'             => 'Bạn chưa nhập Tên khóa học.',
            'name.min'                  => 'Tên khóa học quá ngắn.',
            'name.max'                  => 'Tên khóa học quá dài.',

            'short_description.required'=> 'Bạn chưa nhập Tóm tắt.',
            'short_description.max'     => 'Tóm tắt quá dài.',

            'description.required'      => 'Bạn chưa nhập Mô tả.',
            
            'requirement.required'      => 'Bạn chưa nhập Yêu cầu của khóa học.',

            'link_intro.required'       => 'Bạn chưa nhập Video giới thiệu.',

            'original_price.required'   => 'Bạn chưa nhập Giá gốc khóa học.',
            'original_price.numeric'    => 'Giá khóa học phải là số.',
            'original_price.min'        => 'Giá khóa học không thể <0.',
            // 'discount_price.required'   => 'Bạn chưa nhập giá giảm khóa học.',
            'discount_price.numeric'    => 'Giá khóa học phải là số.',
            'discount_price.min'        => 'Giá khóa học không thể <0.',
            
            'approx_time.required'      => 'Bạn chưa nhập Thời gian dự kiến hoàn thành.',
            'approx_time.numeric'       => 'Thời gian dự kiến hoàn thành phải là số.',
            'approx_time.min'           => 'Thời gian dự kiến hoàn thành không thể <0.',
            'approx_time.numeric'       => 'Thời gian dự kiến hoàn thành quá lớn.',

            'will_learn.required'       => 'Bạn chưa nhập Học viên sẽ học được gì.'
        ];
    }
}
