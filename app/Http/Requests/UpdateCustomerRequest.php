<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
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
            'name' => ['required'],
            'phone_number' => ['required', 'digits:10', Rule::unique('customers')->ignore($this->customer)],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên khách hàng.',
            'phone_number.required' => 'Vui lòng nhập số điện thoại.',
            'phone_number.digits' => 'Số điện thoại không hợp lệ.',
            'phone_number.unique' => 'Số điện thoại đã tồn tại.',
        ];
    }
}
