<?php

namespace App\Http\Controllers\Auth\V1\Request;

use Dingo\Api\Http\FormRequest;

class SocialBindRequest extends FormRequest
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
            'verification_key' => 'required|string',
            'verification_code' => 'required|string',
            'openid' => 'required|string',
        ];
    }

}
