<?php

namespace App\Policies;

use App\Models\Feature;
use App\Models\TitheUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeaturePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Features.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(TitheUser $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the Feature.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(TitheUser $user, Feature $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can create Features.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(TitheUser $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the Feature.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(TitheUser $user, Feature $feature)
    {
        return $feature->plans()->count() === 0;
    }

    /**
     * Determine whether the user can delete the Feature.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(TitheUser $user, Feature $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the Feature.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(TitheUser $user, Feature $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the Feature.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(TitheUser $user, Feature $feature)
    {
        return true;
    }
}
