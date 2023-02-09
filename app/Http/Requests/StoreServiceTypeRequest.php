<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceTypeRequest extends FormRequest
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
            'name' => ['required', 'unique:service_types'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên loại dịch vụ.',
            'name.unique' => 'Tên loại dịch vụ đã tồn tại.',
        ];
    }
}
