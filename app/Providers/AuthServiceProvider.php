<?php

namespace App\Providers;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('event-update',function ($user, Event $event){
            return $user->id === $event->user_id;
        });

        Gate::define('attendee-delete',function ($user , Event $event , Attendee $attendee){
           return ($user->id === $attendee->user_id || $user->id === $event->user_id) ;
        });
    }
}

