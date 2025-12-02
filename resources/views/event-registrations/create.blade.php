<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Добавить регистрацию
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('event-registrations.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="events_eventID" class="block text-gray-700 text-sm font-bold mb-2">Мероприятие:</label>
                            <select name="events_eventID" id="events_eventID" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                @foreach ($events as $event)
                                    <option value="{{ $event->eventID }}">{{ $event->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="users_userID" class="block text-gray-700 text-sm font-bold mb-2">Пользователь:</label>
                            <select name="users_userID" id="users_userID" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->userID }}">{{ $user->user_lastName }} {{ $user->user_firstName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="statusEventRegistration" class="block text-gray-700 text-sm font-bold mb-2">Статус:</label>
                            <input type="text" name="statusEventRegistration" id="statusEventRegistration" value="active" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Создать
                            </button>
                            <a href="{{ route('event-registrations.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                Отмена
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

