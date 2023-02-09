<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceTypeRequest extends FormRequest
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
            'name' => ['required', Rule::unique('service_types')->ignore($this->service_type)],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên loại dịch vụ.',
            'name.unique' => 'Tên dịch vụ đã tồn tại.',
        ];
    }
}
