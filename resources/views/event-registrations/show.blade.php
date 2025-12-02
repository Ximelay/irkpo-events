<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Просмотр регистрации
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <strong class="text-gray-700">ID:</strong>
                        <p class="text-gray-900">{{ $eventRegistration->registrationID }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="text-gray-700">Мероприятие:</strong>
                        <p class="text-gray-900">{{ $eventRegistration->event->title }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="text-gray-700">Пользователь:</strong>
                        <p class="text-gray-900">{{ $eventRegistration->user->user_lastName }} {{ $eventRegistration->user->user_firstName }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="text-gray-700">Статус:</strong>
                        <p class="text-gray-900">{{ $eventRegistration->statusEventRegistration }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="text-gray-700">Дата регистрации:</strong>
                        <p class="text-gray-900">{{ $eventRegistration->registrationDate }}</p>
                    </div>
                    <a href="{{ route('event-registrations.index') }}" class="text-blue-500 hover:underline">Назад к списку</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

