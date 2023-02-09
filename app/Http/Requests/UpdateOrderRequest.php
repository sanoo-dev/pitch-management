<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        return [
            'price' => ['required'],
            'pitch_id' => ['required'],
            'time_end' => ['required', 'date_format:"Y-m-d H:i"', 'after:time_start'],
        ];
    }

    public function messages()
    {
        return [
            'price' => 'Có lỗi xảy ra',
            'pitch_id' => 'Vui lòng chọn sân',
            'time_end.after' => 'Thời gian kết thúc phải sau thời gian bắt đầu.',
        ];
    }
}
