<?php
namespace App\Http\Controllers\Frontends\Requests;
use Illuminate\Foundation\Http\FormRequest;

class InsertTeacherRequest extends FormRequest
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
            'name'          => 'required|min:3|max:50',
            'phone'         => 'required|max:20|regex_phone:"/^[\+]?[(]?[0-9]{1,3}[)]?[-\s]?[0-9]{1,3}[-\s]?[0-9]{4,9}$/"',
            'cv'            => 'required',
            'expert'        => 'required|max:255',
            'address'       => 'max:255',
            'birthday'      => 'date_format:"d/m/Y"|regex:/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/|validate_birthday',
            // 'video-intro'   => 'required|regex:/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/|validate_youtube_url',
        ];
    }

    public function messages()
    {
        return [
            'email.regex_email'         => 'The email must be a valid email address.',
            'email.regex_phone'         => 'The phone must be a valid.',
        ];
    }
}
