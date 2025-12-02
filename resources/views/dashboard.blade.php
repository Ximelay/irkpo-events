<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg">Группы</h3>
                    <ul class="mt-4 space-y-2">
                        <li>
                            <a href="{{ route('groups.index') }}" class="text-blue-500 hover:underline">Группы</a>
                        </li>
                        <li>
                            <a href="{{ route('curators.index') }}" class="text-blue-500 hover:underline">Кураторы</a>
                        </li>
                        <li>
                            <a href="{{ route('organizers.index') }}" class="text-blue-500 hover:underline">Организаторы</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg">Специальности</h3>
                    <ul class="mt-4 space-y-2">
                        <li>
                            <a href="{{ route('faculties.index') }}" class="text-blue-500 hover:underline">Факультеты</a>
                        </li>
                        <li>
                            <a href="{{ route('specialties.index') }}" class="text-blue-500 hover:underline">Специальности</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg">Другое</h3>
                    <ul class="mt-4 space-y-2">
                        <li>
                            <a href="{{ route('inventory-categories.index') }}" class="text-blue-500 hover:underline">Категории инвентаря</a>
                        </li>
                        <li>
                            <a href="{{ route('inventories.index') }}" class="text-blue-500 hover:underline">Инвентарь</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
