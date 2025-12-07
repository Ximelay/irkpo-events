<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Просмотр инвентаря
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <strong class="text-gray-700">ID:</strong>
                        <p class="text-gray-900">{{ $inventory->inventoryID }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="text-gray-700">Название:</strong>
                        <p class="text-gray-900">{{ $inventory->nameInventory }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="text-gray-700">Количество на складе:</strong>
                        <p class="text-gray-900">{{ $inventory->countInventory }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="text-gray-700">Категория:</strong>
                        <p class="text-gray-900">{{ $inventory->inventoryCategories->nameInventoryCategory }}</p>
                    </div>

                    <!-- Мероприятия, использующие этот инвентарь -->
                    <div class="mb-4 mt-6 pt-6 border-t">
                        <strong class="text-gray-700 text-lg">Используется в мероприятиях:</strong>
                        @if($inventory->events->count() > 0)
                            <div class="mt-3">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Мероприятие</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Количество</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Дата добавления</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($inventory->events as $event)
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-gray-900">
                                                    <a href="{{ route('events.show', $event->eventID) }}" class="text-blue-600 hover:text-blue-800">
                                                        {{ $event->title }}
                                                    </a>
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-900">
                                                    <span class="font-semibold text-blue-600">{{ $event->pivot->quantity }}</span>
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-900">
                                                    {{ $event->pivot->addedAt ? \Carbon\Carbon::parse($event->pivot->addedAt)->format('d.m.Y H:i') : '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-600 mt-2">Этот инвентарь пока не используется ни в одном мероприятии.</p>
                        @endif
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('inventories.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">Назад к списку</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

