<?php

namespace App\Policies;

use App\Models\Feature;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeaturePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Features.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the Feature.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Feature  $Feature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Feature $Feature)
    {
        return true;
    }

    /**
     * Determine whether the user can create Features.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the Feature.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Feature  $Feature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Feature $Feature)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the Feature.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Feature  $Feature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Feature $Feature)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the Feature.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Feature  $Feature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Feature $Feature)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the Feature.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Feature  $Feature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Feature $Feature)
    {
        return true;
    }
}
