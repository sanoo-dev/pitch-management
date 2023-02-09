<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePitchTypeRequest extends FormRequest
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
            'name' => ['required', 'unique:pitch_types'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'price' => ['required', 'numeric'],
            'capacity' => ['required', 'numeric'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên loại sân.',
            'name.unique' => 'Tên loại sân đã tồn tại.',
            'image.image' => 'Hình ảnh không hợp lệ.',
            'image.mimes' => 'Chỉ chấp nhận hình ảnh định dạng png, jpg, jpeg.',
            'image.max' => 'Kích thước hình ảnh <= 2048MB',
            'price.required' => 'Vui lòng nhập giá tiền.',
            'price.numeric' => 'Giá tiền không hợp lệ.',
            'capacity.required' => 'Vui lòng nhập số lượng người.',
            'capacity.numeric' => 'Số lượng người không hợp lệ.',
        ];
    }
}
