<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
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
            'name' => 'required|max:100',
            'unit_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Bạn chưa nhập tên bài học.',
            'name.max'      => 'Tên bài học quá dài. (Yêu cầu <100 ký tự)'
        ];
    }
}
