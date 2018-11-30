<?php

namespace App\Http\Controllers\Media\V1\Request;

use Dingo\Api\Http\FormRequest;

class MediaRequest extends FormRequest
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
                    'type' => 'required|string|in:image,video',
                ];
            case 'POST':
                $rules = [
                    'type' => 'required|string|in:image,video,lottie',
                ];

                if ($this->type == 'image') {
                    $rules['file'] = 'filled|mimes:jpeg,jpg,png,gif|max:10240';
                } else if ($this->type == 'video') {
                    $rules['file'] = 'filled|mimes:mp4,wmv|max:51200';
                } else {
                    $rules['file'] = 'filled';
                }

                return $rules;
            case 'PATCH':
                return [
                    'name' => 'filled'
                ];
            case 'DELETE':
                return [
                    'ids' => 'required|array|max:10'
                ];
        }
    }

    public function attributes()
    {
        return [
            'type' => '文件类型',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => '文件类型不能为空',
        ];
    }



}