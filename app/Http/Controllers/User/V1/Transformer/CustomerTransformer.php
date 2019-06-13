<?php

namespace App\Http\Controllers\User\V1\Transformer;

use App\Models\Customer;
use App\Models\User;
use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Permission;

class CustomerTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['roles'];

    public function transform(Customer $customer)
    {
        return [
            'id' => $customer->id,
            'name' => $customer->name,
            'email' => $customer->email,
            'avatar' => $customer->avatar,
            'phone' => $customer->phone,
            'z' => $customer->z,
            'bind_weixin' => $customer->weixin_openid || $customer->weixin_unionid,
            'created_at' => $customer->created_at->toDateTimeString(),
            'updated_at' => $customer->updated_at->toDateTimeString(),
        ];
    }

    public function includeRoles(Customer $customer)
    {
        return $this->collection($customer->roles, new RoleTransformer());
    }

}