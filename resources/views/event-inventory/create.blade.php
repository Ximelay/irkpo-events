<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Добавить инвентарь к мероприятию: {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('event-inventory.store') }}">
                        @csrf
                        <input type="hidden" name="events_eventID" value="{{ $event->eventID }}">

                        <!-- Выбор инвентаря -->
                        <div class="mb-4">
                            <label for="inventories_inventoryID" class="block text-sm font-medium text-gray-700">
                                Инвентарь <span class="text-red-500">*</span>
                            </label>
                            @if($availableInventories->count() > 0)
                                <select name="inventories_inventoryID" id="inventories_inventoryID"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('inventories_inventoryID') border-red-500 @enderror"
                                        required>
                                    <option value="">Выберите инвентарь</option>
                                    @foreach($availableInventories as $inventory)
                                        <option value="{{ $inventory->inventoryID }}" {{ old('inventories_inventoryID') == $inventory->inventoryID ? 'selected' : '' }}>
                                            {{ $inventory->nameInventory }}
                                            ({{ $inventory->inventoryCategories->nameInventoryCategory ?? 'Без категории' }})
                                            - Доступно: {{ $inventory->countInventory }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <p class="mt-1 text-sm text-gray-600">Весь доступный инвентарь уже добавлен к этому мероприятию.</p>
                            @endif
                            @error('inventories_inventoryID')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Количество -->
                        <div class="mb-4">
                            <label for="quantity" class="block text-sm font-medium text-gray-700">
                                Количество <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="quantity" id="quantity" min="1" value="{{ old('quantity', 1) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('quantity') border-red-500 @enderror"
                                   required>
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Кнопки -->
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('events.show', $event->eventID) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Отмена
                            </a>
                            @if($availableInventories->count() > 0)
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Добавить
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

