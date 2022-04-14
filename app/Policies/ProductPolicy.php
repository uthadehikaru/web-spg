<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
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

    public function list(User $user)
    {
        return $user->is_admin;
    }

    public function sync(User $user)
    {
        return $user->is_admin;
    }

    public function print(User $user)
    {
        return $user->is_admin;
    }

    public function api(User $user)
    {
        return $user;
    }
}
