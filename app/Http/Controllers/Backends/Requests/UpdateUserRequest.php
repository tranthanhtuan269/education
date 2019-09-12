<?php

namespace App\Http\Controllers\Backends\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name'              => 'required|min:3|max:49',
            'email'             => 'required|regex_email:"/^[_a-zA-Z0-9-]{2,}+(\.[_a-zA-Z0-9-]{2,}+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/"|unique:users,email,'.$this->user,
            'role_id'           => 'required',
            'password'          => 'required|min:8|max:99',
            'confirmpassword'   => 'required|same:password',
        ];
    }
    public function messages(){
        return [
            'name.required' => 'Bạn chưa nhập tên',
            'name.min' => 'Tên cần có 3 ký tự trở lên',
            'name.max' => 'Tên cần có ít hơn 50 ký tự',
            'email.required' => 'Bạn chưa nhập email',
            'email.unique' => 'Email đã tồn tại!',
            'email.regex_email' => 'Email sai định dạng',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            'password.min' => 'Mật khẩu cần có 8 ký tự trở lên',
            'password.max' => 'Mật khẩu cần có ít hơn 100 ký tự',
            'confirmpassword.required' => 'Vui lòng nhập lại mật khẩu',
            'confirmpassword.same' => 'Mật khẩu chưa khớp',
            'role_id.required' => 'Bạn chưa chọn vai trò'
        ];
    }


}
