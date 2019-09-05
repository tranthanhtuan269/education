<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class StoreDiscussionRequest extends FormRequest
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
            'content' => 'required|max:255'
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'Bạn chưa nhập nội dung.',
            'content.max'      => 'Nội dung quá dài. (Yêu cầu <255 ký tự)'
        ];
    }

}
