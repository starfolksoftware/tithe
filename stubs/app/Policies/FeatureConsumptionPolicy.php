<?php

namespace App\Policies;

use App\Models\FeatureConsumption;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeatureConsumptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Feature Consumptions.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the FeatureConsumption.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, FeatureConsumption $FeatureConsumption)
    {
        return true;
    }

    /**
     * Determine whether the user can create Feature Consumptions.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the FeatureConsumption.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, FeatureConsumption $FeatureConsumption)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the FeatureConsumption.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, FeatureConsumption $FeatureConsumption)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the FeatureConsumption.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, FeatureConsumption $FeatureConsumption)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the FeatureConsumption.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, FeatureConsumption $FeatureConsumption)
    {
        return true;
    }
}
