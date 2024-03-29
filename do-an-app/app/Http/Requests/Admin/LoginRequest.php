<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'username' => 'required|string',
            'password' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'username.required' => 'Không được để trống',
            'username.string' => 'Phải là chuỗi',
            'password.required' => 'Không được để trống'
        ];
    }
}
