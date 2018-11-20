<?php

namespace App\Http\Controllers\Admin\Order\V1\Transformer;

use App\Http\Controllers\Admin\Customer\V1\Transformer\CustomerTransformer;
use App\Http\Controllers\Admin\Store\V1\Transformer\OpticalStoreTransformer;
use App\Http\Controllers\Admin\Order\V1\Models\Order;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['opticalStore', 'customer'];

    public function transform(Order $order){
        return [
            'order_id' => $order->order_id,
            'date_added' => $order->date_added,
            'total' => $order->total,
        ];
    }

    public function includeOpticalStore(Order $order)
    {
        return $this->item($order->opticalStore, new OpticalStoreTransformer());
    }

    public function includeCustomer(Order $order)
    {
        return $this->item($order->customer, new CustomerTransformer());
    }
}