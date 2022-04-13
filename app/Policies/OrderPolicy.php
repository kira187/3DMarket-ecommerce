<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function author(User $user, Order $order)
    {
        return ($order->user_id == $user->id);
    }

    public function paymentOrder(User $user, Order $order)
    {
        return ($order->status == Order::PENDIENTE);
    }
}
