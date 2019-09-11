<?php
namespace App\Http\Controllers\Frontends\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ChangePassUserRequest extends FormRequest
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
            'password_old'=>'required|check_pass',
            'password'=>'required|min:8|max:32|different:password_old|regex:/^\S*$/',
            'confirmpassword'=>'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'password_old.required'        => 'Bạn chưa nhập mật khẩu hiện tại.',
            'password_old.check_pass'      => 'Mật khẩu hiện tại chưa chính xác.',

            'password.required'            => 'Bạn chưa nhập mật khẩu mới.',
            'password.min'                 => 'Mật khẩu mới phải có ít nhất 8 ký tự',
            'password.max'                 => 'Mật khẩu mới có tối đa 32 ký tự.',
            'password.different'           => 'Mật khẩu mới và mật khẩu hiện tại trùng nhau.',
            'password.regex'               => 'Mật khẩu mới không được phép có khoảng trắng.',            

            'confirmpassword.required'     => 'Bạn chưa Xác nhận mật khẩu.',
            'confirmpassword.same'         => 'Mật khẩu và Xác nhận mật khẩu không trùng nhau.',
        ];
    }
}
