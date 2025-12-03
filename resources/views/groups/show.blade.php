<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Просмотр группы
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <strong class="text-gray-700">ID:</strong>
                        <p class="text-gray-900">{{ $group->groupID }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="text-gray-700">Название:</strong>
                        <p class="text-gray-900">{{ $group->groupName }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="text-gray-700">Специальность:</strong>
                        <p class="text-gray-900">{{ $group->speciality->specialityName }}</p>
                    </div>
                    <a href="{{ route('groups.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">Назад к списку</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

