<?php

namespace App\Policies;

use App\Models\TitheUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TitheUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any TitheUsers.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the TitheUser.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, TitheUser $titheUser)
    {
        return true;
    }

    /**
     * Determine whether the user can create TitheUsers.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the TitheUser.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, TitheUser $titheUser)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the TitheUser.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, TitheUser $titheUser)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the TitheUser.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, TitheUser $titheUser)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the TitheUser.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, TitheUser $titheUser)
    {
        return true;
    }
}
