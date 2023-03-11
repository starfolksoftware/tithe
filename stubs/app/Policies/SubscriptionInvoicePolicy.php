<?php

namespace App\Policies;

use App\Models\SubscriptionInvoice;
use App\Models\TitheUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionInvoicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Subscription Invoices.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(TitheUser $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the SubscriptionInvoice.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(TitheUser $user, SubscriptionInvoice $SubscriptionInvoice)
    {
        return true;
    }

    /**
     * Determine whether the user can create Subscription Invoices.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(TitheUser $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the SubscriptionInvoice.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(TitheUser $user, SubscriptionInvoice $SubscriptionInvoice)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the SubscriptionInvoice.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(TitheUser $user, SubscriptionInvoice $SubscriptionInvoice)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the SubscriptionInvoice.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(TitheUser $user, SubscriptionInvoice $SubscriptionInvoice)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the SubscriptionInvoice.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(TitheUser $user, SubscriptionInvoice $SubscriptionInvoice)
    {
        return true;
    }
}
