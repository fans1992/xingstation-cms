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
            'new_password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8|same:new_password',
        ];
    }
}
