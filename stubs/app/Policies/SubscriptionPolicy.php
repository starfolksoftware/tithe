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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the Subscription.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Subscription  $Subscription
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Subscription $Subscription)
    {
        return true;
    }

    /**
     * Determine whether the user can create Subscriptions.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the Subscription.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Subscription  $Subscription
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Subscription $Subscription)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the Subscription.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Subscription  $Subscription
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Subscription $Subscription)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the Subscription.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Subscription  $Subscription
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Subscription $Subscription)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the Subscription.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Subscription  $Subscription
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Subscription $Subscription)
    {
        return true;
    }
}
