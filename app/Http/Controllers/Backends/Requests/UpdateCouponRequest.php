<?php

namespace App\Http\Controllers\Backends\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
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
            'coupon_code'   => 'required|max:15',
            'coupon_value'  => 'required|numeric|min:1|max:100',
            'coupon_expired'=> 'required',
            'course_id'     => 'required',
        ];
    }

    public function messages(){
        return [
            'coupon_code.required'      => 'Bạn chưa nhập mã Coupon',
            'coupon_code.unique'        => 'Mã giảm giá đã tồn tại',
            'coupon_code.max'           => 'Mã COUPON quá dài (Yêu cầu <15 ký tự)',

            'coupon_value.required'     => 'Bạn chưa nhập số % được giảm',
            'coupon_value.min'          => '% giá giảm không thể < 1',
            'coupon_value.max'          => '% giá giảm không thể > 100',
            
            'coupon_expired.required'   => 'Bạn chưa chọn ngày hết hạn COUPON',
            'course_id.required'        => 'Chưa có khóa học nào được chọn',
        ];
    }
}
