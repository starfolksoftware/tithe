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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the SubscriptionInvoicePayment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SubscriptionInvoicePayment  $feature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SubscriptionInvoicePayment $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can create SubscriptionInvoicePayments.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the SubscriptionInvoicePayment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SubscriptionInvoicePayment  $feature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SubscriptionInvoicePayment $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the SubscriptionInvoicePayment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SubscriptionInvoicePayment  $feature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SubscriptionInvoicePayment $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the SubscriptionInvoicePayment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SubscriptionInvoicePayment  $feature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SubscriptionInvoicePayment $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the SubscriptionInvoicePayment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SubscriptionInvoicePayment  $feature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SubscriptionInvoicePayment $feature)
    {
        return true;
    }
}
