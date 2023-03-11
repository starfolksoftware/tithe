<?php

namespace App\Policies;

use App\Models\FeatureTicket;
use App\Models\TitheUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeatureTicketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any FeatureTickets.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(TitheUser $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the FeatureTicket.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(TitheUser $user, FeatureTicket $FeatureTicket)
    {
        return true;
    }

    /**
     * Determine whether the user can create FeatureTickets.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(TitheUser $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the FeatureTicket.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(TitheUser $user, FeatureTicket $FeatureTicket)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the FeatureTicket.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(TitheUser $user, FeatureTicket $FeatureTicket)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the FeatureTicket.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(TitheUser $user, FeatureTicket $FeatureTicket)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the FeatureTicket.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(TitheUser $user, FeatureTicket $FeatureTicket)
    {
        return true;
    }
}
