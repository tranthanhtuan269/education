<?php

namespace App\Http\Controllers\Backends\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'name' => 'required|max:150|unique:categories,name',
            'image' => 'required',
            'icon' => 'required',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Bạn chưa nhập tên Danh mục.',
            'name.max' => 'Tên danh mục nhập quá 150 ký tự.',
            'name.unique'   => 'Tên Danh mục đã tồn tại.',
            'image.required'=> 'Bạn chưa chọn ảnh đại diện Danh mục.',
            'icon.required' => 'Bạn chưa nhập icon Danh mục.'
        ];
    }
}
