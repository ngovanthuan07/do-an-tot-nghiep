<?php

namespace App\Http\Requests\Salon;

use Illuminate\Foundation\Http\FormRequest;

class EditServiceRequest extends FormRequest
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
            'name' => 'required',
            'cse_id' => 'required',
            'price' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên dịch vụ không được để trống',
            'cse_id.required' => 'Vui lòng chọn loại dịch vụ',
            'price.required' => 'Giá dich vụ không được để trống',
        ];
    }
}
