<?php

namespace App\Http\Controllers\Material\V1\Request;

use Dingo\Api\Http\FormRequest;

class MaterialRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch ($this->method()) {
            case "GET":
                return [
                    'perPage' => 'required|numeric|min:1',
                ];
                break;
            case 'POST':
                return [
                    'type' => 'required|string|in:IMAGE,LOTTIE,VIDEO,AUDIO',
                    'name' => 'required|string',
                ];
                break;
            case 'PUT':
                return [];
                break;
        }

    }

    public function attributes()
    {
        return [
            'type' => '素材类型',
            'name' => '素材名称',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => '素材类型不能为空',
            'type.in' => '素材类型有误',
            'name.required' => '素材名称不能为空',
        ];
    }

}