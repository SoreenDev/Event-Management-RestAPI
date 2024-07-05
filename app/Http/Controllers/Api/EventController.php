<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Traits\CanLoadRelationship;
use App\Models\Event;
use Illuminate\Http\Request;
use function Symfony\Component\Translation\t;

class EventController extends Controller
{
   use CanLoadRelationship;
   protected array $relations = ['user','attendees','attendees.user'];
    public function index()
    {

        $query = $this->LoadRelationship(Event::query());
        return EventResource::collection( $query->paginate() );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $event = Event::create([
           ...$request->validate(
               [
                   'name' => 'required|string|max:255',
                   'description' => 'nullable|string',
                   'start_time' => 'required|date|',
                   'end_time' => 'required|date|after:start_time'
               ]
           ),
            'user_id' =>1
        ]);
        return new EventResource( $this->LoadRelationship($event) );
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return new EventResource($this->LoadRelationship($event));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $event->update(
            $request->validate(
                [
                    'name' => 'sometimes|string|max:255',
                    'description' => 'nullable|string',
                    'start_time' => 'sometimes|date|',
                    'end_time' => 'sometimes|date|after:start_time'
                ]
            ));

        return new EventResource($this->LoadRelationship($event));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return response(status: 204);
    }
}
