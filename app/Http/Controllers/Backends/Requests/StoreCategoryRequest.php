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
            'name' => 'required|unique:categories,name',
            // 'image' => 'required',
            'parent_id' => 'required',
            'featured' => 'required',
            'icon' => 'required',
        ];
    }
}
