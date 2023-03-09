<?php

namespace App\Policies;

use App\Models\CreditCard;
use App\Models\TitheUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class CreditCardPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any CreditCards.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(TitheUser $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the CreditCard.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(TitheUser $user, CreditCard $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can create CreditCards.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(TitheUser $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the CreditCard.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(TitheUser $user, CreditCard $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the CreditCard.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(TitheUser $user, CreditCard $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the CreditCard.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(TitheUser $user, CreditCard $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the CreditCard.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(TitheUser $user, CreditCard $feature)
    {
        return true;
    }
}
