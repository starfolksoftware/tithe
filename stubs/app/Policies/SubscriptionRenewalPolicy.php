<?php

namespace App\Policies;

use App\Models\SubscriptionRenewal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionRenewalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Subscription Renewals.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the SubscriptionRenewal.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SubscriptionRenewal $SubscriptionRenewal)
    {
        return true;
    }

    /**
     * Determine whether the user can create Subscription Renewals.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the SubscriptionRenewal.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SubscriptionRenewal $SubscriptionRenewal)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the SubscriptionRenewal.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SubscriptionRenewal $SubscriptionRenewal)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the SubscriptionRenewal.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SubscriptionRenewal $SubscriptionRenewal)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the SubscriptionRenewal.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SubscriptionRenewal $SubscriptionRenewal)
    {
        return true;
    }
}
