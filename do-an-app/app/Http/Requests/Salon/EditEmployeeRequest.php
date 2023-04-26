<?php

namespace App\Http\Requests\Salon;

use Illuminate\Foundation\Http\FormRequest;

class EditEmployeeRequest extends FormRequest
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
            'fullname' => 'required',
            'phone' => 'required|digits:10|numeric',
            'dob' => 'required',
            'cic' => 'required|numeric|digits:9,12',
            'gender' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'fullname.required' => 'Không được để trống',
            'phone.required' => 'không được để trông',
            'phone.digits' => 'Số điện thoại phải 10 số',
            'phone.numeric' => 'Phải là số [0-9]',
            'dob.required' => 'Không được để trống',
            'cic.required' => 'Không được để trống',
            'cic.numeric' => 'Phải là số [0-9]',
            'cic.digits' => 'Nếu là CMND là 9 số, CCCD là 12 số',
            'gender.required' => 'Vui lòng chọn giới tính',
            'gender.numeric' => 'Phải là số',
        ];
    }
}
