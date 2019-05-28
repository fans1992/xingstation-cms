<?php

namespace App\Policies;

use App\Http\Controllers\Material\V1\Models\Material;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Customer;

class MaterialPolicy
{
    use HandlesAuthorization;

    public function own(Customer $customer, Material $material)
    {
        return $customer->isAuthorOf($material) || $customer->isAdmin();
    }
}
