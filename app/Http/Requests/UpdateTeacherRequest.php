<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateTeacherRequest extends FormRequest
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
            'name'          => 'required|min:3|max:50',
            'phone'         => 'required|min:10|max:11|regex_phone:"/^[\+]?[(]?[0-9]{1,3}[)]?[-\s]?[0-9]{1,3}[-\s]?[0-9]{4,9}$/"',
            'cv'            => 'required',
            'expert'        => 'required|max:55',
            'address'       => 'required|max:255',
            'dob'           => 'date_format:"d/m/Y"|regex:/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/|validate_dob',
            'password'          => 'min:8|max:101',
            'confirm_password'   => 'same:password',
            // 'video-intro'   => 'required|regex:/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/|validate_youtube_url',
        ];
    }

    public function messages()
    {
        return [
            'name.required'             => 'Bạn chưa nhập Họ tên.',
            'name.min'                  => 'Họ tên phải có ít nhất 3 ký tự.',
            'name.max'                  => 'Họ tên được phép có tối đa 50 ký tự.',

            'phone.required'            => 'Bạn chưa nhập số điện thoại.',
            'phone.regex_phone'         => 'Số điện thoại không tồn tại.',
            'phone.min'                 => 'Số điện thoại không tồn tại.',
            'phone.max'                 => 'Số điện thoại không tồn tại.',

            'cv.required'               => 'Bạn chưa nhập CV.',

            'expert.required'           => 'Bạn chưa nhập Chuyên môn.',
            'expert.max'           => 'Chuyên môn phải có số kí tự nhỏ hơn 55',

            'address.max'               => 'Địa chỉ quá dài. Vui lòng nhập ít hơn 255 ký tự',
            'address.required'  => 'Bạn chưa nhập địa chỉ',

            'dob.date_format'      => 'Ngày sinh phải có định dạng Ngày/Tháng/Năm (Ví dụ: 31/12/1993).',

            'password.min' => 'Mật khẩu cần có 8 ký tự trở lên',
            'password.max' => 'Mật khẩu cần có ít hơn 100 ký tự',
            // 'confirm_password.required' => 'Vui lòng nhập lại mật khẩu',
            'confirm_password.same' => 'Mật khẩu chưa khớp',
        ];
    }
}
