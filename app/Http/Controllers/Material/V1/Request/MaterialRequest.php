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
        return [
            'category' => 'required|string|in:image,video,animation',
            'attribute' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'category' => '素材类型',
        ];
    }

    public function messages()
    {
        return [
            'category.required' => '素材类型不能为空',
            'category.in' => '素材类型有误'
        ];
    }

}