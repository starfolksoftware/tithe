<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Subscriptions.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the Subscription.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Subscription $Subscription)
    {
        return true;
    }

    /**
     * Determine whether the user can create Subscriptions.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the Subscription.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Subscription $Subscription)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the Subscription.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Subscription $Subscription)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the Subscription.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Subscription $Subscription)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the Subscription.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Subscription $Subscription)
    {
        return true;
    }
}
