<?php
namespace App\Http\Controllers\Frontends\Requests;
use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
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
            'login_email'             => 'required|regex_email:"/^[_a-zA-Z0-9-]{2,}+(\.[_a-zA-Z0-9-]{2,}+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/"',
            'login_password'          => 'required',
        ];
    }

    public function messages()
    {
        return [
            'login_email.required'            => 'Bạn chưa nhập địa chỉ Email.',
            'login_email.regex_email'         => 'Địa chỉ Email không tồn tại.',

            'login_password.required'         => 'Bạn chưa nhập Mật khẩu.',
        ];
    }
}
