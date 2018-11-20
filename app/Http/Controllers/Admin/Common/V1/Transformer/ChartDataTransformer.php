<?php

namespace App\Http\Controllers\Admin\Common\V1\Transformer;

use League\Fractal\TransformerAbstract;

class ChartDataTransformer extends TransformerAbstract
{
    public function transform($chartData)
    {
        /**
         * @todo 优化
         */
        return [
            'display_name' => $chartData->display_name,
            'count' => (int)$chartData->count,
            'index' => (string)$chartData->index
        ];
    }

}