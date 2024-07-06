<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Http\Traits\CanLoadRelationship;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
 use CanLoadRelationship;
 protected array $relations =["user"];
    public function index(Event $event)
    {
        $attendees = $this->LoadRelationship($event->attendees()->latest());
        return AttendeeResource::collection(
            $attendees->paginate()
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Event $event)
    {
        $attendee = $event->attendees()->create([
            'user_id' => 1
        ]);

        return new AttendeeResource($this->LoadRelationship($attendee));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event,Attendee $attendee)
    {
        return new AttendeeResource($this->LoadRelationship($attendee));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event,Attendee $attendee)
    {
        $attendee->delete();

        return response(status:204);

    }
}
