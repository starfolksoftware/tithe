<?php

namespace Tithe\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class FeaturePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Features.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny($user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the Feature.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view($user, $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can create Features.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create($user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the Feature.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update($user, $feature)
    {
        return $feature->plans()->count() === 0;
    }

    /**
     * Determine whether the user can delete the Feature.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete($user, $feature)
    {
        return $feature->plans()->count() === 0;
    }

    /**
     * Determine whether the user can restore the Feature.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore($user, $feature)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the Feature.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete($user, $feature)
    {
        return true;
    }
}
