<?php

namespace App\Http\Controllers\Admin\Store\V1\Transformer;

use App\Http\Controllers\Admin\Store\V1\Models\OpticalStore;
use League\Fractal\TransformerAbstract;

class OpticalStoreTransformer extends TransformerAbstract
{
    public function transform(OpticalStore $opticalStore){
        return [
            'optical_store_id' => $opticalStore->optical_store_id,
            'address' => $opticalStore->address,
            'name' => $opticalStore->name,
            'internal_name' => $opticalStore->internal_name,
            'intro' => $opticalStore->intro,
            'tips' => $opticalStore->tips,
        ];
    }
}