<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Просмотр факультета
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <strong class="text-gray-700">ID:</strong>
                        <p class="text-gray-900">{{ $faculty->facultyID }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="text-gray-700">Название:</strong>
                        <p class="text-gray-900">{{ $faculty->facultyName }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="text-gray-700">Глава:</strong>
                        <p class="text-gray-900">{{ $faculty->facultyHead }}</p>
                    </div>
                    <a href="{{ route('faculties.index') }}" class="text-blue-500 hover:underline">Назад к списку</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

