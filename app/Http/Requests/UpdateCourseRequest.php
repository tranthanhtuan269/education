<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
            'name' => 'required|max:255',
            'short_description' => 'required|max:255',
            'description' => 'required',
            'will_learn' => 'required|max:255',
            'requirement' => 'required|max:255',
            'price' => 'required|numeric',
            'level' => 'required|numeric',
            'approx_time' => 'required|numeric',
            'category' => 'required|numeric'
        ];
    }
}
