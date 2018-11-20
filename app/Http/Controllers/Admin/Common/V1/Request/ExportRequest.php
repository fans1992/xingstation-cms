<?php

namespace App\Http\Controllers\Admin\Common\V1\Request;

use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => ['required', Rule::in(['marketing', 'point', 'project','daily_average','project_point','marketing_top'])]
        ];
    }
}
