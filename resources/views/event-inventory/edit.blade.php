<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Редактировать количество инвентаря
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold">Мероприятие:</h3>
                        <p class="text-gray-700">{{ $eventInventory->event->title }}</p>

                        <h3 class="text-lg font-semibold mt-4">Инвентарь:</h3>
                        <p class="text-gray-700">
                            {{ $eventInventory->inventory->nameInventory }}
                            <span class="text-sm text-gray-500">
                                ({{ $eventInventory->inventory->inventoryCategories->nameInventoryCategory ?? 'Без категории' }})
                            </span>
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            Доступно на складе: {{ $eventInventory->inventory->countInventory }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('event-inventory.update', $eventInventory->eventInventoryID) }}">
                        @csrf
                        @method('PUT')

                        <!-- Количество -->
                        <div class="mb-4">
                            <label for="quantity" class="block text-sm font-medium text-gray-700">
                                Количество для мероприятия <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="quantity" id="quantity" min="1"
                                   value="{{ old('quantity', $eventInventory->quantity) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('quantity') border-red-500 @enderror"
                                   required>
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Кнопки -->
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('events.show', $eventInventory->events_eventID) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Отмена
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Сохранить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

