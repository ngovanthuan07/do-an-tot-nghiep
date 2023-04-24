<?php

namespace App\Http\Requests\Admin\Salon;

use Illuminate\Foundation\Http\FormRequest;

class AddSalonRequest extends FormRequest
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
            'phone' => 'required|digits:10|numeric|unique:salon,phone',
            'address' => 'required',
            'username' => 'required|email|unique:salon,username',
            'password' => 'required|min:6',
            'ward' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Không được để trống',
            'phone.required' => 'Không được để trống',
            'phone.digits' => 'Số điện thoại phải là 10 chữ số',
            'phone.numeric' => 'Phải là số',
            'phone.unique' => 'Số điện thoại đã được đăng kí',
            'address.required' => 'Không được để trống',
            'username.required' => 'Không được để trống',
            'username.email' => 'Tên đăng nhập phải là email',
            'username.unique' => 'Tài khoản đã tồn tại vui lòng đăng kí tài khoản khác',
            'password.required' => 'Không được để trống',
            'password.min' => 'Mật khẩu tối đa 6 kí tự',
            'ward.required' => 'Không được để trống',

        ];
    }
}
