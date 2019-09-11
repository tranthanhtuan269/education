<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class StoreReportRequest extends FormRequest
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
            "message" => "required|max:499",
            "title" => "required|max:149"
        ];
    }
    public function messages(){
        return [
            "message.required" => "Bạn chưa nhập mô tả lỗi!",
            "message.max" => "Mô tả quá dài, hãy nhập mô tả ít hơn 500 ký tự",
            "title.required" => "Bạn chưa nhập tiêu đề!",
            "title.max" => "Tiêu đề quá dài, hãy nhập tiêu đề ít hơn 150 ký tự"
        ];
    }
}
