<?php

namespace App\Http\Controllers\Admin\Media\V1\Request;

use Dingo\Api\Http\FormRequest;

class MediaRequest extends FormRequest
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
        switch ($this->method()) {
            case "GET":
                return [
                    'type' => 'required|string|in:image,video',
                ];
            case 'POST':
                $rules = [
                    'type' => 'required|string|in:image,video',
                ];

                if ($this->type == 'image') {
                    $rules['file'] = 'filled|mimes:jpeg,jpg,png,gif|max:10240';
                } else {
                    $rules['file'] = 'filled|mimes:mp4|max:51200';
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
}
