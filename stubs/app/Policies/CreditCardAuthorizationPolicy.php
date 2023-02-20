<?php

namespace App\Policies;

use App\Models\CreditCardAuthorization;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CreditCardAuthorizationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any CreditCardAuthorizations.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the CreditCardAuthorization.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, CreditCardAuthorization $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can create CreditCardAuthorizations.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the CreditCardAuthorization.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, CreditCardAuthorization $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the CreditCardAuthorization.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, CreditCardAuthorization $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the CreditCardAuthorization.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, CreditCardAuthorization $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the CreditCardAuthorization.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, CreditCardAuthorization $feature)
    {
        return true;
    }
}
