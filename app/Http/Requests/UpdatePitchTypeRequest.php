<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePitchTypeRequest extends FormRequest
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
            'name' => ['required', Rule::unique('pitch_types')->ignore($this->pitch_type)],
            'image' => ['nullable', 'mimes:png,jpg,jpeg'],
            'price' => ['required', 'numeric'],
            'capacity' => ['required', 'numeric'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên loại sân bóng.',
            'name.unique' => 'Tên loại sân bóng đã tồn tại.',
            'image.mimes' => 'Chỉ chấp nhận hình ảnh định dạng png, jpg, jpeg.',
            'price.required' => 'Vui lòng nhập giá tiền.',
            'price.numeric' => 'Giá tiền không hợp lệ.',
            'capacity.required' => 'Vui lòng nhập số lượng người.',
            'capacity.numeric' => 'Số lượng người không hợp lệ.',
        ];
    }
}
