<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $eventType->eventType }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('event-types.edit', $eventType->eventTypeID) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Редактировать
                </a>
                <a href="{{ route('event-types.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Назад к списку
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Информация о типе мероприятия</h3>

                        <div class="mb-3">
                            <span class="font-bold text-gray-700">ID:</span>
                            <p class="text-gray-900">{{ $eventType->eventTypeID }}</p>
                        </div>

                        <div class="mb-3">
                            <span class="font-bold text-gray-700">Название типа:</span>
                            <p class="text-gray-900">{{ $eventType->eventType }}</p>
                        </div>

                        <div class="mb-3">
                            <span class="font-bold text-gray-700">Количество мероприятий:</span>
                            <p class="text-gray-900">{{ $eventType->events->count() }}</p>
                        </div>
                    </div>

                    @if($eventType->events->count() > 0)
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4">Мероприятия с этим типом</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Название</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Начало</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Место</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($eventType->events as $event)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $event->title }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($event->startDateTime)->format('d.m.Y H:i') }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $event->location }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('events.show', $event->eventID) }}" class="text-blue-600 hover:text-blue-900">Просмотр</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

