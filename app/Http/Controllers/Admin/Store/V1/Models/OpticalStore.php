<?php

namespace App\Http\Controllers\Admin\Store\V1\Models;

use App\Http\Controllers\Admin\Order\V1\Models\Order;
use App\Models\FreeCartModel;

class OpticalStore extends FreeCartModel
{
    protected $table = 'optical_store';

    public function orders()
    {
        return $this->hasMany(Order::class, 'optical_store_id', 'optical_store_id');
    }
}
