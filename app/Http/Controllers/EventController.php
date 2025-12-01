<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use App\Models\EventStatus;
use App\Models\Organizer;
use App\Models\Faculty;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Отображение списка всех мероприятий
     */
    public function index()
    {
        $events = Event::with(['eventType', 'eventStatus', 'organizer', 'faculty'])
            ->orderBy('startDateTime', 'desc')
            ->paginate(15);

        return view('events.index', compact('events'));
    }

    /**
     * Отображение формы создания нового мероприятия
     */
    public function create()
    {
        $eventTypes = EventType::all();
        $eventStatuses = EventStatus::all();
        $organizers = Organizer::all();
        $faculties = Faculty::all();

        return view('events.create', compact('eventTypes', 'eventStatuses', 'organizers', 'faculties'));
    }

    /**
     * Сохранение нового мероприятия
     */
    public function store(StoreEventRequest $request)
    {
        $event = Event::create($request->validated());

        return redirect()
            ->route('events.show', $event->eventID)
            ->with('success', 'Мероприятие успешно создано!');
    }

    /**
     * Отображение конкретного мероприятия
     */
    public function show(Event $event)
    {
        $event->load(['eventType', 'eventStatus', 'organizer', 'faculty', 'registrations.user']);

        return view('events.show', compact('event'));
    }

    /**
     * Отображение формы редактирования мероприятия
     */
    public function edit(Event $event)
    {
        $eventTypes = EventType::all();
        $eventStatuses = EventStatus::all();
        $organizers = Organizer::all();
        $faculties = Faculty::all();

        return view('events.edit', compact('event', 'eventTypes', 'eventStatuses', 'organizers', 'faculties'));
    }

    /**
     * Обновление мероприятия
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->validated());

        return redirect()
            ->route('events.show', $event->eventID)
            ->with('success', 'Мероприятие успешно обновлено!');
    }

    /**
     * Удаление мероприятия
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Мероприятие успешно удалено!');
    }
}

