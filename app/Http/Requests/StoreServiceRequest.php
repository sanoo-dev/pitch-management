<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'name' => ['required', 'unique:services'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'price' => ['required', 'numeric'],
            'service_type_id' => ['required'],
            'inventory' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên dịch vụ.',
            'name.unique' => 'Tên dịch vụ đã tồn tại.',
            'image.image' => 'Hình ảnh không hợp lệ.',
            'image.mimes' => 'Chỉ chấp nhận hình ảnh định dạng png, jpg, jpeg.',
            'image.max' => 'Kích thước hình ảnh <= 2048MB',
            'price.required' => 'Vui lòng nhập giá tiền.',
            'price.numeric' => 'Giá tiền không hợp lệ.',
            'service_type_id.required' => 'Vui lòng chọn loại dịch vụ.',
            'inventory.required' => 'Vui lòng nhập số lượng tồn kho.',
        ];
    }
}
