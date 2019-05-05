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
            'settings.title' => 'required|string',
//            'comList' => 'required',
//            'pageList' => 'required',
        ];

    }

    public function attributes()
    {
        return [
            'title' => '作品名称',
//            'comList' => '组件列表',
//            'pageList' => '页面列表',
        ];
    }

    public function messages()
    {
        return [];
    }

}