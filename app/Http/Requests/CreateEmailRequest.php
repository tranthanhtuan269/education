<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class CreateEmailRequest extends FormRequest
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
            'title' => 'required|max:150',
            'content' => 'required'
        ];
    }
    public function messages() {
        return [
            'title.required' => "Bạn chưa điền chủ đề của Email",
            'title.max' => "Bạn đã nhập quá 150 kí tự",
            'content.required' => "Bạn chưa điền nội dung của Email",
        ];
    }
}
