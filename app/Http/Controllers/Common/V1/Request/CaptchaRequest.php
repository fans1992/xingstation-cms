<?php

namespace App\Http\Controllers\Common\V1\Request;

use Dingo\Api\Http\FormRequest;

class CaptchaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone' => 'required|regex:/^1[3456789]\d{9}$/',
        ];
    }
}
