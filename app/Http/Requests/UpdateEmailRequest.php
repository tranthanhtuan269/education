<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateEmailRequest extends FormRequest
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
            'title' => 'required|max:150|unique:emails,title,'.$this->id,
            'content' => 'required'
        ];
    }
    public function messages() {
        return [
            'title.required' => "Bạn chưa điền chủ đề của Email",
            'title.unique' => "Chủ đề bị trùng",
            'title.max' => "Bạn đã nhập quá 150 kí tự",
            'title.unique' => "Chủ đề bị trùng tên",
            'content.required' => "Bạn chưa điền nội dung của Email",
        ];
    }
}
