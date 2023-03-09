<?php

namespace App\Policies;

use App\Models\SubscriptionRenewal;
use App\Models\TitheUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionRenewalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Subscription Renewals.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(TitheUser $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the SubscriptionRenewal.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(TitheUser $user, SubscriptionRenewal $SubscriptionRenewal)
    {
        return true;
    }

    /**
     * Determine whether the user can create Subscription Renewals.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(TitheUser $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the SubscriptionRenewal.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(TitheUser $user, SubscriptionRenewal $SubscriptionRenewal)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the SubscriptionRenewal.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(TitheUser $user, SubscriptionRenewal $SubscriptionRenewal)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the SubscriptionRenewal.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(TitheUser $user, SubscriptionRenewal $SubscriptionRenewal)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the SubscriptionRenewal.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(TitheUser $user, SubscriptionRenewal $SubscriptionRenewal)
    {
        return true;
    }
}
