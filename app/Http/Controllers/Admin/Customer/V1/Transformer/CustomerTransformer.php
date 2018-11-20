<?php

namespace App\Http\Controllers\Admin\Customer\V1\Transformer;

use App\Http\Controllers\Admin\Customer\V1\Models\Customer;
use League\Fractal\TransformerAbstract;

class CustomerTransformer extends TransformerAbstract
{
    public function transform(Customer $customer){
        return [
            'customer_id' => $customer->customer_id,
            'mobile' => $customer->mobile,
        ];
    }
}