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
                    'category' => 'required|string|in:image,video,lottie',
                    'attribute' => 'required',
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
            'category' => '素材类型',
            'attribute' => '素材属性',
        ];
    }

    public function messages()
    {
        return [
            'category.required' => '素材类型不能为空',
            'category.in' => '素材类型有误',
            'attribute.required' => '素材属性不能为空',
        ];
    }

}