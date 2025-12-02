<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Регистрации на мероприятия
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Список регистраций</h3>
                        <a href="{{ route('event-registrations.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Добавить регистрацию
                        </a>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                            <span class="block sm:inline">{{ $message }}</span>
                        </div>
                    @endif

                    <table class="min-w-full bg-white mt-4">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">ID</th>
                                <th class="py-2 px-4 border-b">Мероприятие</th>
                                <th class="py-2 px-4 border-b">Пользователь</th>
                                <th class="py-2 px-4 border-b">Статус</th>
                                <th class="py-2 px-4 border-b">Дата регистрации</th>
                                <th class="py-2 px-4 border-b">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registrations as $registration)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $registration->registrationID }}</td>
                                    <td class="py-2 px-4 border-b">{{ $registration->event->title }}</td>
                                    <td class="py-2 px-4 border-b">{{ $registration->user->user_lastName }} {{ $registration->user->user_firstName }}</td>
                                    <td class="py-2 px-4 border-b">{{ $registration->statusEventRegistration }}</td>
                                    <td class="py-2 px-4 border-b">{{ $registration->registrationDate }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="{{ route('event-registrations.show', $registration) }}" class="text-blue-500 hover:underline">Просмотр</a>
                                        <a href="{{ route('event-registrations.edit', $registration) }}" class="text-yellow-500 hover:underline ml-2">Редактировать</a>
                                        <form action="{{ route('event-registrations.destroy', $registration) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline ml-2">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

