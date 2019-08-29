<?php
namespace App\Http\Controllers\Frontends\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileUserRequest extends FormRequest
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
            'address'       => 'max:255',
            'phone'         => 'required|min:10|max:11|regex_phone:"/^[\+]?[(]?[0-9]{1,3}[)]?[-\s]?[0-9]{1,3}[-\s]?[0-9]{4,9}$/"',
            'birthday'      => 'date_format:"d/m/Y"|regex:/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/|validate_birthday',
        ];
    }

    public function messages()
    {
        return [
            'name.required'             => 'Bạn chưa nhập tên.',
            'name.min'                  => 'Tên phải có ít nhất 3 ký tự.',
            'name.max'                  => 'Tên được phép có tối đa 50 ký tự.',

            'address.max'               => 'Địa chỉ quá dài.',
            
            'phone.required'            => 'Bạn chưa nhập số điện thoại.',
            'phone.max'                 => 'Số điện thoại không tồn tại.',
            'phone.regex_phone'         => 'Số điện thoại không tồn tại.',
            'phone.min'                 => 'Số điện thoại không tồn tại.',

            'birthday.date_format'      => 'Ngày sinh phải có định dạng Ngày/Tháng/Năm (Ví dụ: 31/12/1993).'
        ];
    }
}
