<?php

namespace App\Policies;

use App\Models\SubscriptionInvoice;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionInvoicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Subscription Invoices.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the SubscriptionInvoice.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SubscriptionInvoice $SubscriptionInvoice)
    {
        return true;
    }

    /**
     * Determine whether the user can create Subscription Invoices.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the SubscriptionInvoice.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SubscriptionInvoice $SubscriptionInvoice)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the SubscriptionInvoice.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SubscriptionInvoice $SubscriptionInvoice)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the SubscriptionInvoice.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SubscriptionInvoice $SubscriptionInvoice)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the SubscriptionInvoice.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SubscriptionInvoice $SubscriptionInvoice)
    {
        return true;
    }
}
