<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;


    //新生成的策略类 要到

    public function before($user, $ability)
    {
    }
}
