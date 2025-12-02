<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Редактировать куратора
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

                    <form action="{{ route('curators.update', $curator) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="curator_lastName" class="block text-gray-700 text-sm font-bold mb-2">Фамилия:</label>
                            <input type="text" name="curator_lastName" id="curator_lastName" value="{{ $curator->curator_lastName }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <div class="mb-4">
                            <label for="curator_firstName" class="block text-gray-700 text-sm font-bold mb-2">Имя:</label>
                            <input type="text" name="curator_firstName" id="curator_firstName" value="{{ $curator->curator_firstName }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <div class="mb-4">
                            <label for="curator_middleName" class="block text-gray-700 text-sm font-bold mb-2">Отчество:</label>
                            <input type="text" name="curator_middleName" id="curator_middleName" value="{{ $curator->curator_middleName }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label for="groups_groupID" class="block text-gray-700 text-sm font-bold mb-2">Группа:</label>
                            <select name="groups_groupID" id="groups_groupID" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->groupID }}" @if($curator->groups_groupID == $group->groupID) selected @endif>{{ $group->groupName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Обновить
                            </button>
                            <a href="{{ route('curators.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                Отмена
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

