<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Http\Controllers\Work\V1\Models\Work;
use App\Models\Customer;

class WorkPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return bool
     */
    public function own(Customer $customer, Work $work)
    {
        return $customer->isAuthorOf($work) || $customer->isAdmin();
    }
}
