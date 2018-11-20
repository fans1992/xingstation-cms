<?php

namespace App\Http\Controllers\Auth\V1\Request;

use Dingo\Api\Http\FormRequest;

class CustomerAuthorizationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
            'captcha_key' => 'required|string',
            'captcha_code' => 'required|string',
        ];
    }
}
