<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Просмотр регистрации группы
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Информация о регистрации</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-600 text-sm">Мероприятие:</p>
                                <p class="font-medium">{{ $eventGroupRegistration->event->title }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Группа:</p>
                                <p class="font-medium">{{ $eventGroupRegistration->group->groupName }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Специальность:</p>
                                <p class="font-medium">{{ $eventGroupRegistration->group->speciality->specialityName ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Статус:</p>
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ $eventGroupRegistration->statusGroupRegistration === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $eventGroupRegistration->statusGroupRegistration }}
                                </span>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Дата регистрации:</p>
                                <p class="font-medium">{{ $eventGroupRegistration->registrationDate }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Студенты группы ({{ $eventGroupRegistration->group->users->count() }})</h3>
                        @if($eventGroupRegistration->group->users->count() > 0)
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b text-left">ФИО</th>
                                        <th class="py-2 px-4 border-b text-left">Email</th>
                                        <th class="py-2 px-4 border-b text-left">Статус</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($eventGroupRegistration->group->users as $user)
                                        <tr>
                                            <td class="py-2 px-4 border-b">
                                                {{ $user->user_lastName }} {{ $user->user_firstName }} {{ $user->user_middleName }}
                                            </td>
                                            <td class="py-2 px-4 border-b">{{ $user->user_email ?? '-' }}</td>
                                            <td class="py-2 px-4 border-b">
                                                <span class="px-2 py-1 text-xs rounded-full {{ $user->user_isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $user->user_isActive ? 'Активен' : 'Неактивен' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-gray-500">В группе нет студентов.</p>
                        @endif
                    </div>

                    <div class="mt-6 flex space-x-4">
                        <a href="{{ route('event-group-registrations.edit', $eventGroupRegistration) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Редактировать
                        </a>
                        <a href="{{ route('event-group-registrations.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Назад к списку
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

