<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderServiceRequest extends FormRequest
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
            'quantity' => ['required', 'numeric'],
        ];
    }

    public function messages()
    {
        return [
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.numeric' => 'Số lượng không hợp lệ',
        ];
    }
}
