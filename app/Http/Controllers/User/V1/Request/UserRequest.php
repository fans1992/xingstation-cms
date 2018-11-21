<?php

namespace App\Http\Controllers\User\V1\Request;

use Dingo\Api\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
//            'verification_key' => 'required|string',
//            'verification_code' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'verification_key' => '短信验证码 key',
            'verification_code' => '短信验证码',
        ];
    }

    public function messages()
    {
        return [
            'verification_key.required' => '短信验证码key不能为空',
            'verification_code.required' => '短信验证码不能为空',
        ];
    }

}