<?php

namespace App\Policies;

use App\Models\SubscriptionInvoicePayment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionInvoicePaymentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any SubscriptionInvoicePayments.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the SubscriptionInvoicePayment.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SubscriptionInvoicePayment $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can create SubscriptionInvoicePayments.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the SubscriptionInvoicePayment.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SubscriptionInvoicePayment $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the SubscriptionInvoicePayment.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SubscriptionInvoicePayment $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the SubscriptionInvoicePayment.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SubscriptionInvoicePayment $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the SubscriptionInvoicePayment.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SubscriptionInvoicePayment $feature)
    {
        return true;
    }
}
