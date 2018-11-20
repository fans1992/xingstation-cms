<?php

namespace App\Http\Controllers\Admin\Common\V1\Request;

use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChartDataRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|integer',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d'
        ];
    }
}
