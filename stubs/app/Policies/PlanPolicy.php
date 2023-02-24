<?php

namespace App\Policies;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Plans.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the Plan.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Plan $Plan)
    {
        return true;
    }

    /**
     * Determine whether the user can create Plans.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the Plan.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Plan $Plan)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the Plan.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Plan $Plan)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the Plan.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Plan $Plan)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the Plan.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Plan $Plan)
    {
        return true;
    }
}
