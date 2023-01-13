<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RolesPolicy
{

    use HandlesAuthorization;


    public function index(User $user)
    {
        return $user->role_id == 1
            ? Response::allow()
            : Response::deny('You are not allowed to perform this action.');
    }


    public function store(User $user)
    {
        return $user->role_id == 1
            ? Response::allow()
            : Response::deny('You are not allowed to perform this action.');
    }

    public function update(User $user)
    {
        return $user->role_id == 1
            ? Response::allow()
            : Response::deny('You are not allowed to perform this action.');
    }

    public function delete(User $user)
    {
        return $user->role_id == 1
            ? Response::allow()
            : Response::deny('You are not allowed to perform this action.');
    }

}
