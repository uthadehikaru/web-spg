<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
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

    public function create(User $user)
    {
        return $user->is_admin === false;
    }

    public function request(User $user)
    {
        return $user->is_admin === false;
    }

    public function edit(User $user, Order $order)
    {
        return $order->c_order_id==null && ($user->is_admin || $user->id==$order->user_id);
    }

    public function cancel(User $user, Order $order)
    {
        return $order->status=='processed' && ($user->is_admin || $user->id==$order->user_id);
    }

    public function reactive(User $user, Order $order)
    {
        return $order->status=='cancel' && ($user->is_admin || $user->id==$order->user_id);
    }
}
