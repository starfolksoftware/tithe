<?php

namespace App\Policies;

use App\Models\TitheUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class TitheUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any TitheUsers.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(TitheUser $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the TitheUser.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(TitheUser $user, TitheUser $titheUser)
    {
        return true;
    }

    /**
     * Determine whether the user can create TitheUsers.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(TitheUser $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the TitheUser.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(TitheUser $user, TitheUser $titheUser)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the TitheUser.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(TitheUser $user, TitheUser $titheUser)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the TitheUser.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(TitheUser $user, TitheUser $titheUser)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the TitheUser.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(TitheUser $user, TitheUser $titheUser)
    {
        return true;
    }
}
