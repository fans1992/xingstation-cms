<?php

namespace App\Policies;

use App\Http\Controllers\Work\V1\Models\Work;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function own(User $user, Work $work)
    {
        return $user->isAuthorOf($work) || $user->isAdmin();
    }
}
