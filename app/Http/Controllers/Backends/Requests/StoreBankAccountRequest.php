<?php

namespace App\Http\Controllers\Backends\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreBankAccountRequest extends FormRequest
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
            'account_name'   => 'required|min:3|max:100',
            'account_number'  => 'required|min:10|max:100',
            'bank_name'=> 'required|max:255',
        ];
    }

    public function messages(){
        return [
            'account_name.required'     => 'Bạn chưa nhập tên tài khoản',
            'account_name.min'          => 'Tên tài khoản quá ngắn',
            'account_name.max'          => 'Tên tài khoản quá dài',

            'account_number.required'   => 'Bạn chưa nhập số tài khoản',
            'account_number.min'        => 'Số tài khoản không hợp lệ',
            'account_number.max'        => 'Số tài khoản không hợp lệ',
            
            'bank_name.required'        => 'Bạn chưa nhập tên ngân hàng',
            'bank_name.mãx'             => 'Tên ngân hàng quá dài',
        ];
    }
}
