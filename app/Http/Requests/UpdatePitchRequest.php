<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePitchRequest extends FormRequest
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
            'name' => ['required', Rule::unique('pitches')->ignore($this->pitch)],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'location' => ['required'],
            'pitch_type_id' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên sân bóng.',
            'name.unique' => 'Tên sân bóng đã tồn tại.',
            'image.image' => 'Hình ảnh không hợp lệ.',
            'image.mimes' => 'Chỉ chấp nhận hình ảnh định dạng png, jpg, jpeg.',
            'image.max' => 'Kích thước hình ảnh <= 2048KB',
            'location.required' => 'Vui lòng nhập địa điểm sân bóng.',
            'pitch_type_id.required' => 'Vui lòng chọn loại sân bóng.'
        ];
    }
}
