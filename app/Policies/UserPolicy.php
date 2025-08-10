<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;



class UserPolicy
{
    use HandlesAuthorization;


    public function register(User $user)
    {
        return $user->role === "admin"  ? Response::allow()
            : Response::deny('You must be admin.');
    }
}
