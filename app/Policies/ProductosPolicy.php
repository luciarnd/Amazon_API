<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProductosPolicy
{
    use HandlesAuthorization;


    public function view(User $user, Producto $producto)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function store(User $user, Producto $producto)
    {
        return $user->role_id==1
            ? Response::allow()
            : Response::deny('You are not allowed to perform this action.');
    }

    public function update(User $user, Producto $producto)
    {
        return $user->role_id==1
            ? Response::allow()
            : Response::deny('You are not allowed to perform this action.');
    }

    public function delete(User $user, Producto $producto)
    {
        return $user->role_id==1
            ? Response::allow()
            : Response::deny('You are not allowed to perform this action.');
    }

    public function restore(User $user, Peticiones $peticiones)
    {
        //
    }
}
