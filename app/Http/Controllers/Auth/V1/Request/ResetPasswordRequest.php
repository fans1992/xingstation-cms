<?php

namespace App\Http\Controllers\Auth\V1\Request;

use Dingo\Api\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8|same:new_password',
        ];
    }

    public function attributes()
    {
        return [
            'old_password' => '旧密码',
            'new_password' => '新密码',
            'confirm_password' => '确认密码',
        ];
    }

    public function messages()
    {
        return [
            'confirm_password.same' => '两次密码不一致,请重新输入',
        ];
    }
}
