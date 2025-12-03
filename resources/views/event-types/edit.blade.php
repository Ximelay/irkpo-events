<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Редактирование типа мероприятия') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('event-types.update', $eventType->eventTypeID) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Название типа -->
                        <div class="mb-4">
                            <label for="eventType" class="block text-gray-700 text-sm font-bold mb-2">
                                Название типа мероприятия <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="eventType" id="eventType" value="{{ old('eventType', $eventType->eventType) }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('eventType') border-red-500 @enderror"
                                   required>
                            @error('eventType')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Кнопки -->
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Обновить
                            </button>
                            <a href="{{ route('event-types.index') }}" class="text-gray-600 hover:text-gray-900">
                                Отмена
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

