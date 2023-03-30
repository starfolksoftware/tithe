<?php

namespace App\Policies;

use App\Models\CreditCardAuthorization;
use App\Models\TitheUser;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;

class CreditCardAuthorizationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any CreditCardAuthorizations.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(TitheUser $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the CreditCardAuthorization.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(TitheUser $user, CreditCardAuthorization $feature)
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
    public function update(TitheUser $user, CreditCardAuthorization $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the CreditCardAuthorization.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(TitheUser $user, CreditCardAuthorization $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the CreditCardAuthorization.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(TitheUser $user, CreditCardAuthorization $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the CreditCardAuthorization.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(TitheUser $user, CreditCardAuthorization $feature)
    {
        return true;
    }
}
