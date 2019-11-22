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
            'description'=> 'required',
            'link_video'=> 'required',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Bạn chưa nhập tên bài giảng.',
            'name.max'      => 'Tên bài giảng quá dài. (Yêu cầu <100 ký tự)',
            'description.required' => 'Bạn chưa nhập mô tả bài giảng.',
            'link_video.required' => 'Bạn chưa chọn video bài giảng.',
        ];
    }
}
