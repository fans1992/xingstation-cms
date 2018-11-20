<?php

namespace App\Http\Controllers\Admin\Store\V1\Models;

use App\Http\Controllers\Admin\Order\V1\Models\Order;
use App\Models\PublicationModel;

class OpticalStore extends PublicationModel
{
    protected $table = 'optical_store';

    public function orders()
    {
        return $this->hasMany(Order::class, 'optical_store_id', 'optical_store_id');
    }
}
