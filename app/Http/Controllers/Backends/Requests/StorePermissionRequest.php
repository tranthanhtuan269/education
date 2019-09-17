<?php
namespace App\Http\Controllers\Backends\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
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
            'name'              => 'required|min:3|max:100|unique:permissions,name',
            'route'             => 'required|min:3|max:100|unique:permissions,route',
            'group'             => 'required'
        ];
    }
    public function messages(){
        return [
            'name.required' => 'Bạn chưa nhập tên quyền',
            'name.min' => 'Bạn nhập chưa đủ 3 kí tự',
            'name.max' => 'Bạn nhập quá 100 kí tự',
            'route.required' => 'Bạn chưa nhập tên vai trò',
            'route.min' => 'Bạn nhập chưa đủ 3 kí tự',
            'route.max' => 'Bạn nhập quá 100 kí tự',
            'group.required' => 'Bạn chưa chọn quyền',
        ];
    }
}
