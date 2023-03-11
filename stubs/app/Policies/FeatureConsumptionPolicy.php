<?php

namespace App\Policies;

use App\Models\FeatureConsumption;
use App\Models\TitheUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeatureConsumptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Feature Consumptions.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(TitheUser $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the FeatureConsumption.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(TitheUser $user, FeatureConsumption $FeatureConsumption)
    {
        return true;
    }

    /**
     * Determine whether the user can create Feature Consumptions.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(TitheUser $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the FeatureConsumption.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(TitheUser $user, FeatureConsumption $FeatureConsumption)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the FeatureConsumption.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(TitheUser $user, FeatureConsumption $FeatureConsumption)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the FeatureConsumption.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(TitheUser $user, FeatureConsumption $FeatureConsumption)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the FeatureConsumption.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(TitheUser $user, FeatureConsumption $FeatureConsumption)
    {
        return true;
    }
}
