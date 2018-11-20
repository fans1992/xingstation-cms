<?php

namespace App\Http\Controllers\Admin\Store\V1\Api;

use App\Http\Controllers\Admin\Store\V1\Transformer\OpticalStoreTransformer;
use App\Http\Controllers\Admin\Store\V1\Request\OpticalStoreRequest;
use App\Http\Controllers\Admin\Store\V1\Models\OpticalStore;
use App\Http\Controllers\Controller;

class OpticalStoresController extends Controller
{
    public function index(OpticalStoreRequest $opticalStoreRequest, OpticalStore $opticalStore)
    {
        $query = $opticalStore->query();

        $opticalStores = $query->where('is_active', 1)->paginate(10);

        return $this->response->paginator($opticalStores, new OpticalStoreTransformer());
    }
}