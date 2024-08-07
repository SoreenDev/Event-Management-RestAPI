<?php

namespace App\Policies;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AttendeePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return  true ;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Attendee $attrndee): bool
    {
       return true ;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Attendee $attrndee,Event $event): bool
    {
        return $user->id === $attrndee->user_id || $user->id === $event->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Attendee $attendee): bool
    {
        return $user->id === $attendee->user_id || $user->id === $attendee->event->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
//    public function restore(User $user, Attrndee $attrndee): bool
//    {
//        //
//    }

    /**
     * Determine whether the user can permanently delete the model.
     */
//    public function forceDelete(User $user, Attrndee $attrndee): bool
//    {
//        //
//    }
}
