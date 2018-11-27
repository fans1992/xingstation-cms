<?php

namespace App\Policies;

use App\Http\Controllers\Material\V1\Models\Material;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaterialPolicy
{
    use HandlesAuthorization;

    public function own(User $user, Material $material)
    {
        return $material->user_id == $user->id;
    }
}
