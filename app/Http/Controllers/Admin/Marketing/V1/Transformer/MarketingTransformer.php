<?php

namespace App\Http\Controllers\Admin\Marketing\V1\Transformer;

use App\Http\Controllers\Admin\Marketing\V1\Models\Marketing;
use League\Fractal\TransformerAbstract;

class MarketingTransformer extends TransformerAbstract
{
    public function transform(Marketing $marketing){
        return [
            'marketing_id' => $marketing->marketing_id,
            'name' => $marketing->name,
            'description' => $marketing->description,
            'start_time' => $marketing->start_time,
            'end_time' => $marketing->end_time,
        ];
    }
}