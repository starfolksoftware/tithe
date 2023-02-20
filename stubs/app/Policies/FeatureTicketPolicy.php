<?php

namespace App\Policies;

use App\Models\FeatureTicket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeatureTicketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any FeatureTickets.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the FeatureTicket.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FeatureTicket  $FeatureTicket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, FeatureTicket $FeatureTicket)
    {
        return true;
    }

    /**
     * Determine whether the user can create FeatureTickets.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the FeatureTicket.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FeatureTicket  $FeatureTicket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, FeatureTicket $FeatureTicket)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the FeatureTicket.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FeatureTicket  $FeatureTicket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, FeatureTicket $FeatureTicket)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the FeatureTicket.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FeatureTicket  $FeatureTicket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, FeatureTicket $FeatureTicket)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the FeatureTicket.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FeatureTicket  $FeatureTicket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, FeatureTicket $FeatureTicket)
    {
        return true;
    }
}
