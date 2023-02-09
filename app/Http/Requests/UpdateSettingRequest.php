<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
            'open_time' => ['required'],
            'close_time' => ['required'],
            'location' => ['required'],
            'location_url' => ['required'],
            'phone' => ['required', 'digits:10'],
            'email' => ['required', 'email'],
        ];
    }

    public function messages()
    {
        return [
            'open_time.required' => 'Vui lòng nhập thời gian mở cửa.',
            'close_time.required' => 'Vui lòng nhập thời gian đóng cửa.',
            'location.required' => 'Vui lòng nhập địa chỉ.',
            'location_url.required' => 'Vui lòng nhập url địa chỉ.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.digits' => 'Số điện thoại không hợp lệ.',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ.'
        ];
    }
}
