<?php

namespace Tithe\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class PlanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Plans.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny($user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the Plan.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view($user, $plan)
    {
        return true;
    }

    /**
     * Determine whether the user can create Plans.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create($user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the Plan.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update($user, $plan)
    {
        return $plan->features()->count() === 0 &&
            $plan->subscriptions()->count() === 0;
    }

    /**
     * Determine whether the user can delete the Plan.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete($user, $plan)
    {
        return $plan->features()->count() === 0 &&
            $plan->subscriptions()->count() === 0;
    }

    /**
     * Determine whether the user can restore the Plan.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore($user, $plan)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the Plan.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete($user, $plan)
    {
        return true;
    }

    /**
     * Determine whether the user can attach a feature the Plan.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function attachFeature($user, $plan)
    {
        return true;
    }

    /**
     * Determine whether the user can detach a feature the Plan.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function detachFeature($user, $plan)
    {
        return true;
    }
}
