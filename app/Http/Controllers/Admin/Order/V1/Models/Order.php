<?php

namespace App\Http\Controllers\Admin\Order\V1\Models;

use App\Http\Controllers\Admin\Customer\V1\Models\Customer;
use App\Http\Controllers\Admin\Store\V1\Models\OpticalStore;
use App\Models\FreeCartModel;

class Order extends FreeCartModel
{
    protected $table = 'order';

    public function opticalStore()
    {
        return $this->belongsTo(OpticalStore::class, 'optical_store_id','optical_store_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}
