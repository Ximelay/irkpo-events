<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventGroupRegistration;
use App\Models\Group;
use Illuminate\Http\Request;

class EventGroupRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registrations = EventGroupRegistration::with(['event', 'group.speciality', 'group.users'])->get();
        return view('event-group-registrations.index', compact('registrations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::all();
        $groups = Group::with('speciality')->get();
        return view('event-group-registrations.create', compact('events', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'events_eventID' => 'required|exists:events,eventID',
            'groups_groupID' => 'required|exists:groups,groupID|unique:eventGroupRegistrations,groups_groupID,NULL,groupRegistrationID,events_eventID,' . $request->events_eventID,
            'statusGroupRegistration' => 'required|string|max:50',
        ], [
            'groups_groupID.unique' => 'Эта группа уже зарегистрирована на данное мероприятие.',
        ]);

        EventGroupRegistration::create($request->all());

        return redirect()->route('event-group-registrations.index')
            ->with('success', 'Группа успешно зарегистрирована на мероприятие.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventGroupRegistration $eventGroupRegistration)
    {
        $eventGroupRegistration->load(['event', 'group.speciality', 'group.users']);
        return view('event-group-registrations.show', compact('eventGroupRegistration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventGroupRegistration $eventGroupRegistration)
    {
        $events = Event::all();
        $groups = Group::with('speciality')->get();
        return view('event-group-registrations.edit', compact('eventGroupRegistration', 'events', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventGroupRegistration $eventGroupRegistration)
    {
        $request->validate([
            'events_eventID' => 'required|exists:events,eventID',
            'groups_groupID' => 'required|exists:groups,groupID|unique:eventGroupRegistrations,groups_groupID,' . $eventGroupRegistration->groupRegistrationID . ',groupRegistrationID,events_eventID,' . $request->events_eventID,
            'statusGroupRegistration' => 'required|string|max:50',
        ], [
            'groups_groupID.unique' => 'Эта группа уже зарегистрирована на данное мероприятие.',
        ]);

        $eventGroupRegistration->update($request->all());

        return redirect()->route('event-group-registrations.index')
            ->with('success', 'Регистрация группы успешно обновлена.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventGroupRegistration $eventGroupRegistration)
    {
        $eventID = $eventGroupRegistration->events_eventID;
        $eventGroupRegistration->delete();

        // Если есть referer и это страница мероприятия, вернуться туда
        $referer = request()->headers->get('referer');
        if ($referer && str_contains($referer, '/events/')) {
            return redirect()->route('events.show', $eventID)
                ->with('success', 'Регистрация группы успешно удалена.');
        }

        return redirect()->route('event-group-registrations.index')
            ->with('success', 'Регистрация группы успешно удалена.');
    }
}

