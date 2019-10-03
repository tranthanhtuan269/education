<?php

namespace App\Http\Controllers\Backends\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name' => 'required|max:25|unique:categories,name,'.$this->id,
            // 'image' => 'required',
            'icon' => 'required',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Bạn chưa nhập tên Danh mục.',
            'name.max'      => 'Tên danh mục quá dài.',
            'name.unique'   => 'Tên danh mục không thể trùng nhau',
            // 'image.required'=> 'Bạn chưa chọn ảnh đại diện Danh mục.',
            'icon.required' => 'Bạn chưa nhập icon Danh mục.'
        ];
    }
}
