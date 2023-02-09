<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;


class StoreOrderRequest extends FormRequest
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
        $now = Carbon::now();
        $two_months_from_now = $now->addMonths(2);
        return [
            'pitch_id' => ['required'],
            'customer_phone_number' => ['required', 'digits:10'],
            'customer_name' => ['required'],
            'time_start' => ['required', 'date_format:"Y-m-d H:i"', 'after:now', 'before:'.$two_months_from_now],
            'time_end' => ['required', 'date_format:"Y-m-d H:i"', 'after:time_start'],
        ];
    }

    public function messages()
    {
        return [
            'pitch_id.required' => 'Vui lòng chọn sân.',
            'customer_phone_number.required' => 'Vui lòng nhập số điện thoại khách hàng.',
            'customer_phone_number.digits' => 'Số điện thoại không hợp lệ.',
            'customer_name.required' => 'Vui lòng nhập tên khách hàng.',
            'time_start.before' => 'Thời gian bắt đầu phải sau thời gian hiện tại không quá 2 tháng.',
            'time_start.after' => 'Thời gian bắt đầu phải sau thời gian hiện tại.',
            'time_end.after' => 'Thời gian kết thúc phải sau thời gian bắt đầu.',
        ];
    }
}
