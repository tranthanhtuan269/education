<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
            'name'              => 'required|min:3|max:120',
            'short_description' => 'required|max:250',
            'description'       => 'required|max:2000',
            'will_learn'        => 'required|max:1000',
            'requirement'       => 'required|max:150',
            'original_price'    => 'required|numeric|min:0|max:10000000',
            'discount_price'    => 'numeric|min:0',
            'approx_time'       => 'required|numeric|min:0|max:999',
            'link_intro'        => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'             => 'Bạn chưa nhập tên khóa học.',
            'name.min'                  => 'Tên khóa học quá ngắn.',
            'name.max'                  => 'Tên khóa học quá dài. Yêu cầu < 120 ký tự.',

            'short_description.required'=> 'Bạn chưa nhập Tóm tắt.',
            'short_description.max'     => 'Tóm tắt quá dài. Yêu cầu < 250 ký tự',
            
            'description.required'      => 'Bạn chưa nhập Mô tả.',
            'description.max'           => 'Mô tả quá dài. Yêu cầu < 2000 ký tự.',
            
            'requirement.required'      => 'Bạn chưa nhập Yêu cầu của khóa học.',
            'requirement.max'           => 'Yêu cầu của khóa học quá dài .Yêu cầu  < 150 ký tự.',

            'link_intro.required'       => 'Bạn chưa nhập Video giới thiệu.',

            'original_price.required'   => 'Bạn chưa nhập Giá gốc khóa học.',
            'original_price.numeric'    => 'Giá khóa học phải là số.',
            'original_price.min'        => 'Giá khóa học không thể < 0.',
            'original_price.max'        => 'Giá khóa học quá lớn.',
            // 'discount_price.required'   => 'Bạn chưa nhập giá giảm khóa học.',
            'discount_price.numeric'    => 'Giá khóa học phải là số.',
            'discount_price.min'        => 'Giá khóa học không thể < 0.',
            
            'approx_time.required'      => 'Bạn chưa nhập Thời gian dự kiến hoàn thành.',
            'approx_time.numeric'       => 'Thời gian dự kiến hoàn thành phải là số.',
            'approx_time.min'           => 'Thời gian dự kiến hoàn thành không thể <0.',
            'approx_time.numeric'       => 'Thời gian dự kiến hoàn thành quá lớn.',
            
            'will_learn.required'       => 'Bạn chưa nhập Học viên sẽ học được gì.',
            'will_learn.mãx'            => 'Phần Học viên sẽ học được quá dài. Yêu cầu < 1000 ký tự.',
        ];
    }
}
