<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\EventType;
use Illuminate\Http\Request;

class EventTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventTypes = EventType::withCount('events')->get();
        return view('event-types.index', compact('eventTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('event-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'eventType' => 'required|string|max:255|unique:eventTypes,eventType',
        ], [
            'eventType.required' => 'Название типа мероприятия обязательно для заполнения',
            'eventType.unique' => 'Тип мероприятия с таким названием уже существует',
            'eventType.max' => 'Название типа мероприятия не должно превышать 255 символов',
        ]);

        EventType::create($validated);

        return redirect()->route('event-types.index')
            ->with('success', 'Тип мероприятия успешно создан');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventType $eventType)
    {
        $eventType->load('events');
        return view('event-types.show', compact('eventType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventType $eventType)
    {
        return view('event-types.edit', compact('eventType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventType $eventType)
    {
        $validated = $request->validate([
            'eventType' => 'required|string|max:255|unique:eventTypes,eventType,' . $eventType->eventTypeID . ',eventTypeID',
        ], [
            'eventType.required' => 'Название типа мероприятия обязательно для заполнения',
            'eventType.unique' => 'Тип мероприятия с таким названием уже существует',
            'eventType.max' => 'Название типа мероприятия не должно превышать 255 символов',
        ]);

        $eventType->update($validated);

        return redirect()->route('event-types.index')
            ->with('success', 'Тип мероприятия успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventType $eventType)
    {
        if ($eventType->events()->count() > 0) {
            return redirect()->route('event-types.index')
                ->with('error', 'Невозможно удалить тип мероприятия, так как он используется в мероприятиях');
        }

        $eventType->delete();

        return redirect()->route('event-types.index')
            ->with('success', 'Тип мероприятия успешно удален');
    }
}
