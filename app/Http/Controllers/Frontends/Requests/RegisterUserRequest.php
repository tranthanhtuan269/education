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
            'email'             => 'required|unique:users,email|regex_email:"/^[_a-zA-Z0-9-]{2,}+(\.[_a-zA-Z0-9-]{2,}+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/"',
            'password'          => 'required|min:8|max:100',
            'confirmpassword'   => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'email.regex_email'         => 'Địa chỉ Email không hợp lệ.',
            'confirmpassword.required'  => 'The confirm field is required.',
            'confirmpassword.same'      => 'The confirm password and password must match.',
        ];
    }
}
