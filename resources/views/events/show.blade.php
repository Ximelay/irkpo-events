<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $event->title }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('events.edit', $event->eventID) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Редактировать
                </a>
                <a href="{{ route('events.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Назад к списку
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Основная информация -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Основная информация</h3>

                            <div class="mb-3">
                                <span class="font-bold text-gray-700">Название:</span>
                                <p class="text-gray-900">{{ $event->title }}</p>
                            </div>

                            <div class="mb-3">
                                <span class="font-bold text-gray-700">Описание:</span>
                                <p class="text-gray-900">{{ $event->description ?? 'Не указано' }}</p>
                            </div>

                            <div class="mb-3">
                                <span class="font-bold text-gray-700">Место проведения:</span>
                                <p class="text-gray-900">{{ $event->location }}</p>
                            </div>

                            <div class="mb-3">
                                <span class="font-bold text-gray-700">Бюджет:</span>
                                <p class="text-gray-900">{{ $event->budget ? number_format($event->budget, 2, ',', ' ') . ' руб.' : 'Не указан' }}</p>
                            </div>
                        </div>

                        <!-- Даты и статусы -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Даты и статусы</h3>

                            <div class="mb-3">
                                <span class="font-bold text-gray-700">Начало:</span>
                                <p class="text-gray-900">{{ \Carbon\Carbon::parse($event->startDateTime)->format('d.m.Y H:i') }}</p>
                            </div>

                            <div class="mb-3">
                                <span class="font-bold text-gray-700">Окончание:</span>
                                <p class="text-gray-900">{{ \Carbon\Carbon::parse($event->endDateTime)->format('d.m.Y H:i') }}</p>
                            </div>

                            <div class="mb-3">
                                <span class="font-bold text-gray-700">Тип мероприятия:</span>
                                <p class="text-gray-900">{{ $event->eventType->eventType ?? 'Не указан' }}</p>
                            </div>

                            <div class="mb-3">
                                <span class="font-bold text-gray-700">Статус:</span>
                                <p class="text-gray-900">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $event->eventStatus->eventStatus ?? 'Не указан' }}
                                    </span>
                                </p>
                            </div>

                            <div class="mb-3">
                                <span class="font-bold text-gray-700">Дата создания:</span>
                                <p class="text-gray-900">{{ $event->createdAt ? \Carbon\Carbon::parse($event->createdAt)->format('d.m.Y H:i') : 'Не указано' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Организаторы и отделения -->
                    <div class="mt-6 pt-6 border-t">
                        <h3 class="text-lg font-semibold mb-4">Организация</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-3">
                                <span class="font-bold text-gray-700">Организатор:</span>
                                <p class="text-gray-900">
                                    {{ $event->organizer->organizer_lastName }}
                                    {{ $event->organizer->organizer_firstName }}
                                    {{ $event->organizer->organizer_middleName }}
                                </p>
                                <p class="text-sm text-gray-600">{{ $event->organizer->jobTitle }}</p>
                            </div>

                            <div class="mb-3">
                                <span class="font-bold text-gray-700">Отделение:</span>
                                <p class="text-gray-900">{{ $event->faculty->facultyName ?? 'Не указано' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Регистрации -->
                    @if($event->registrations->count() > 0)
                        <div class="mt-6 pt-6 border-t">
                            <h3 class="text-lg font-semibold mb-4">Зарегистрированные участники ({{ $event->registrations->count() }})</h3>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ФИО</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Дата регистрации</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($event->registrations as $registration)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $registration->user->user_lastName ?? '' }}
                                                    {{ $registration->user->user_firstName ?? '' }}
                                                    {{ $registration->user->user_middleName ?? '' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $registration->user->user_email ?? '' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $registration->registrationDate ? \Carbon\Carbon::parse($registration->registrationDate)->format('d.m.Y H:i') : '' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        {{ $registration->statusEventRegistration }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Удаление -->
                    <div class="mt-6 pt-6 border-t">
                        <form action="{{ route('events.destroy', $event->eventID) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить это мероприятие? Это действие необратимо.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Удалить мероприятие
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

