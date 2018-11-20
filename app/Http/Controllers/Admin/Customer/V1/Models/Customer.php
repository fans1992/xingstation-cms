<?php

namespace App\Http\Controllers\Admin\Customer\V1\Models;

use App\Http\Controllers\Admin\Order\V1\Models\Order;
use App\Models\FreeCartModel;

class Customer extends FreeCartModel
{
    protected $table = 'customer';

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }
}
