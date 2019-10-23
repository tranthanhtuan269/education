<?php
namespace App\Http\Controllers\Frontends\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileTeacherRequest extends FormRequest
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
            'name'          => 'required|min:3|max:50',
            'expert'        => 'required',
            'cv'            => 'required',
            'address'       => 'max:255',
            'phone'         => 'required|min:10|max:11|regex_phone:"/^[\+]?[(]?[0-9]{1,3}[)]?[-\s]?[0-9]{1,3}[-\s]?[0-9]{4,9}$/"',
            'birthday'      => 'date_format:"d/m/Y"|regex:/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/|validate_birthday',
            'video_intro'   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'             => 'Bạn chưa nhập Họ tên.',
            'name.min'                  => 'Họ tên phải có ít nhất 3 ký tự.',
            'name.max'                  => 'Họ tên được phép có tối đa 50 ký tự.',

            'phone.required'            => 'Bạn chưa nhập Số điện thoại.',
            'phone.regex_phone'         => 'Số điện thoại không tồn tại.',
            'phone.max'                 => 'Số điện thoại không tồn tại.',
            'phone.min'                 => 'Số điện thoại không tồn tại.',
            
            'birthday.date_format'      => 'Ngày sinh phải có định dạng Ngày/Tháng/Năm (Ví dụ: 31/12/1993).',
            
            'address.max'               => 'Địa chỉ quá dài.',
            
            'expert.required'           => 'Bạn chưa nhập Chuyên môn.',

            'cv.required'               => 'Bạn chưa nhập CV.',

            'video_intro.required'      => 'Bạn chưa nhập Video giới thiệu.'
        ];
    }
}
