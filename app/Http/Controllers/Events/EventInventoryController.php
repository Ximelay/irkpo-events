<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventInventory;
use App\Models\Inventory;
use Illuminate\Http\Request;

class EventInventoryController extends Controller
{
    /**
     * Показать форму добавления инвентаря к мероприятию
     */
    public function create(Request $request)
    {
        $eventID = $request->query('event_id');
        $event = Event::findOrFail($eventID);

        // Получаем инвентарь, который ещё не назначен на это мероприятие
        $assignedInventoryIds = $event->assignedInventories()->pluck('inventoryID')->toArray();
        $availableInventories = Inventory::with('inventoryCategories')
            ->whereNotIn('inventoryID', $assignedInventoryIds)
            ->get();

        return view('event-inventory.create', compact('event', 'availableInventories'));
    }

    /**
     * Добавить инвентарь к мероприятию
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'events_eventID' => 'required|exists:events,eventID',
            'inventories_inventoryID' => 'required|exists:inventories,inventoryID',
            'quantity' => 'required|integer|min:1',
        ], [
            'events_eventID.required' => 'Мероприятие обязательно для выбора',
            'inventories_inventoryID.required' => 'Инвентарь обязателен для выбора',
            'quantity.required' => 'Количество обязательно для указания',
            'quantity.min' => 'Количество должно быть не менее 1',
        ]);

        // Проверяем, что такая связь ещё не существует
        $exists = EventInventory::where('events_eventID', $validated['events_eventID'])
            ->where('inventories_inventoryID', $validated['inventories_inventoryID'])
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['inventories_inventoryID' => 'Этот инвентарь уже добавлен к мероприятию.']);
        }

        EventInventory::create($validated);

        return redirect()->route('events.show', $validated['events_eventID'])
            ->with('success', 'Инвентарь успешно добавлен к мероприятию.');
    }

    /**
     * Показать форму редактирования количества инвентаря
     */
    public function edit(EventInventory $eventInventory)
    {
        $eventInventory->load(['event', 'inventory.inventoryCategories']);
        return view('event-inventory.edit', compact('eventInventory'));
    }

    /**
     * Обновить количество инвентаря для мероприятия
     */
    public function update(Request $request, EventInventory $eventInventory)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ], [
            'quantity.required' => 'Количество обязательно для указания',
            'quantity.min' => 'Количество должно быть не менее 1',
        ]);

        $eventInventory->update($validated);

        return redirect()->route('events.show', $eventInventory->events_eventID)
            ->with('success', 'Количество инвентаря успешно обновлено.');
    }

    /**
     * Удалить инвентарь из мероприятия
     */
    public function destroy(EventInventory $eventInventory)
    {
        $eventID = $eventInventory->events_eventID;
        $eventInventory->delete();

        return redirect()->route('events.show', $eventID)
            ->with('success', 'Инвентарь успешно удалён из мероприятия.');
    }
}
