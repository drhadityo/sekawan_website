<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccessControlPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user is a super admin.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function superAdmin(User $user)
    {
        return $user->role === 'superadmin';
    }
}
