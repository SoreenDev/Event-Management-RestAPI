<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends Notification to All event attendees that event start son';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = Event::with('attendees.user')
            ->whereBetween('start_time',[now(),now()->addDay()])
            ->get();
        $events->each(
            fn($event)=> $event->attendees->each(
                fn($attendee)=>$this->info("Notifying the user {$attendee->user_id}" )
            )
        );

        $event_count = $events->count();
        $event_label = Str::plural('event',$event_count);

        $this->info("Found {$event_count} {$event_label}");
        $this->info('Remainders notification sed successfully');
    }
}
