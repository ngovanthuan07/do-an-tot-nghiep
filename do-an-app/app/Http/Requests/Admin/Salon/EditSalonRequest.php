<?php

namespace App\Http\Requests\Admin\Salon;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditSalonRequest extends FormRequest
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
        $id = $this->input('salon_id');
        return [
            'name' => 'required',
            'phone' => [
                'required',
                'digits:10',
                'numeric',
                Rule::unique('salon', 'phone')->ignore($id, 'salon_id'),
            ],
            'address' => 'required',
            'username' => [
                'required',
                'email',
                Rule::unique('salon', 'username')->ignore($id, 'salon_id'),
            ],
            'password' => 'nullable|min:6',
            'ward' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.digits' => 'Số điện thoại phải gồm 10 chữ số',
            'phone.numeric' => 'Số điện thoại phải là số',
            'phone.unique' => 'Số điện thoại đã được sử dụng',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'username.required' => 'Vui lòng nhập tên đăng nhập',
            'username.email' => 'Tên đăng nhập phải là địa chỉ email',
            'username.unique' => 'Tên đăng nhập đã tồn tại',
            'password.min' => 'Mật khẩu phải chứa ít nhất 6 kí tự',
            'ward.required' => 'Vui lòng chọn phường/xã',
        ];
    }
}
