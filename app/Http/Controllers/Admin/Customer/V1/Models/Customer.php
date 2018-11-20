<?php

namespace App\Http\Controllers\Admin\Customer\V1\Models;

use App\Http\Controllers\Admin\Order\V1\Models\Order;
use App\Models\PublicationModel;

class Customer extends PublicationModel
{
    protected $table = 'customer';

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }
}
