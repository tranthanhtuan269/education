<?php
namespace App\Http\Controllers\Frontends\Requests;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'name'              => 'required|min:3|max:50',
            'email'             => 'required|unique:users,email|regex_email:"/^[_a-zA-Z0-9-]{3,}+(\.[_a-zA-Z0-9-]{3,}+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/"',
            'password'          => 'required|min:8|max:32|regex:/^\S*$/',
            'confirmpassword'   => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'name.required'             => 'Bạn chưa nhập tên.',
            'name.min'                  => 'Tên phải có ít nhất 3 ký tự.',
            'name.max'                  => 'Tên được phép có tối đa 50 ký tự.',

            'email.required'            => 'Bạn chưa nhập email.',
            'email.unique'              => 'Địa chỉ email đã tồn tại.',
            'email.regex_email'         => 'Địa chỉ Email không hợp lệ.',

            'password.required'         => 'Bạn chưa nhập mật khẩu.',
            'password.min'              => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.max'              => 'Mật khẩu được phép có tối đa 32 ký tự ký tự.',
            'password.regex'            => 'Mật khẩu không được phép có khoảng trắng.',

            'confirmpassword.required'  => 'Bạn chưa nhập lại mật khẩu.',
            'confirmpassword.same'      => 'Mật khẩu và Nhập lại mật khẩu không trùng nhau.',
        ];
    }
}
