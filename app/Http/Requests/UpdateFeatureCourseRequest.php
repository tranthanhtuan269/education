<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateFeatureCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_1' => 'required',
            'course_2' => 'required',
            'course_3' => 'required',
            'percent_feature_course' => 'required|numeric|min:0|max:99'
        ];
    }

    public function messages(){
        return [
            'course_1.required'               => 'Vui lòng chọn khoá học nổi bật',
            'course_2.required'               => 'Vui lòng chọn khoá học nổi bật',
            'course_3.required'               => 'Vui lòng chọn khoá học nổi bật',
            'percent_feature_course.required' => 'Vui lòng nhập phần trăm giảm giá',
            'percent_feature_course.numeric'  => 'Phần trăm giảm giá phải là số',
            'percent_feature_course.min'      => 'Phần trăm giảm giá phải lớn hơn 0',
            'percent_feature_course.max'      => 'Phần trăm giảm giá phải nhỏ hơn 100'
        ];
    }
}
