<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
        $id = Auth::guard('customer')->user()->customer_id;
        return [
            'fullname' => 'required',
            'phone' => [
                'required',
                'digits:10',
                'numeric',
                Rule::unique('customer', 'phone')->ignore($id, 'customer_id'),
            ],
            'gender' => 'required',
            'dob' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'fullname.required' => 'Vui lòng nhập tên',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.digits' => 'Số điện thoại phải gồm 10 chữ số',
            'phone.numeric' => 'Số điện thoại phải là số',
            'phone.unique' => 'Số điện thoại đã được sử dụng',
            'gender.required' => 'Vui lòng chọn giới tính',
            'dob.required' => 'Vui lòng nhập ngày sinh'
        ];
    }
}
