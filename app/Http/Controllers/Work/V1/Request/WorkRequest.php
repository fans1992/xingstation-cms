<?php

namespace App\Http\Controllers\Work\V1\Request;

use Dingo\Api\Http\FormRequest;

class WorkRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'status' => 'required',
            'comList' => 'required',
            'pageList' => 'required',
        ];

    }

    public function attributes()
    {
        return [
//            'status' => '作品状态',
//            'comList' => '组件列表',
//            'pageList' => '页面列表',
        ];
    }

    public function messages()
    {
        return [
            'status.required' => '素材类型不能为空',
            'category.in' => '素材类型有误'
        ];
    }

}