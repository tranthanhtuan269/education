<?php
namespace App\Http\Controllers\Frontends\Requests;
use Illuminate\Foundation\Http\FormRequest;

class InsertTeacherRequest extends FormRequest
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
            'phone'         => 'required|max:20|regex_phone:"/^[\+]?[(]?[0-9]{1,3}[)]?[-\s]?[0-9]{1,3}[-\s]?[0-9]{4,9}$/"',
            'cv'            => 'required',
            'expert'        => 'required',
            'address'       => 'max:255',
            'birthday'      => 'date_format:"d/m/Y"|regex:/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/|validate_birthday',
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
            'phone.max'                 => 'Số điện thoại không tồn tại.',

            'cv.required'               => 'Bạn chưa nhập CV.',

            'expert.required'           => 'Bạn chưa nhập Chuyên môn.',

            'address.max'               => 'Địa chỉ quá dài.',

            'birthday.date_format'      => 'Ngày sinh phải có định dạng Ngày/Tháng/Năm (Ví dụ: 31/12/1993).'
        ];
    }
}
