<?php

namespace App\Policies;

use App\Entities\Role;
use App\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view, create, edit and delete employees.
     *
     * @param  \App\Entities\User  $user
     * @return mixed
     */
    public function categories(User $user)
    {
        $role = Role::find(1);
        if($user->role_id == $role->id)
            return true;
        return false;
    }
}
