<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventGroupRegistration;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Http\Request;

class EventRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registrations = EventRegistration::with(['event', 'user.group'])->get();
        return view('event-registrations.index', compact('registrations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::all();
        $users = User::all();
        return view('event-registrations.create', compact('events', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'events_eventID' => 'required|exists:events,eventID',
            'users_userID' => 'required|exists:users,userID|unique:eventRegistrations,users_userID,NULL,registrationID,events_eventID,' . $request->events_eventID,
            'statusEventRegistration' => 'required|string|max:50',
        ]);

        // Проверяем, не участвует ли студент уже через свою группу
        if (EventGroupRegistration::isUserParticipatingThroughGroup($request->events_eventID, $request->users_userID)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['users_userID' => 'Этот студент уже участвует в мероприятии через свою группу.']);
        }

        EventRegistration::create($request->all());

        return redirect()->route('event-registrations.index')
            ->with('success', 'Registration created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventRegistration $eventRegistration)
    {
        return view('event-registrations.show', compact('eventRegistration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventRegistration $eventRegistration)
    {
        $events = Event::all();
        $users = User::all();
        return view('event-registrations.edit', compact('eventRegistration', 'events', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventRegistration $eventRegistration)
    {
        $request->validate([
            'events_eventID' => 'required|exists:events,eventID',
            'users_userID' => 'required|exists:users,userID|unique:eventRegistrations,users_userID,' . $eventRegistration->registrationID . ',registrationID,events_eventID,' . $request->events_eventID,
            'statusEventRegistration' => 'required|string|max:50',
        ]);

        // Проверяем, не участвует ли студент уже через свою группу
        if (EventGroupRegistration::isUserParticipatingThroughGroup($request->events_eventID, $request->users_userID)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['users_userID' => 'Этот студент уже участвует в мероприятии через свою группу.']);
        }

        $eventRegistration->update($request->all());

        return redirect()->route('event-registrations.index')
            ->with('success', 'Registration updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventRegistration $eventRegistration)
    {
        $eventRegistration->delete();

        return redirect()->route('event-registrations.index')
            ->with('success', 'Registration deleted successfully');
    }
}
