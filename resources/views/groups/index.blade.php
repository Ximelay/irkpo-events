<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Группы
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Список групп</h3>
                        <a href="{{ route('groups.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Добавить группу
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
                                <th class="py-2 px-4 border-b">Название</th>
                                <th class="py-2 px-4 border-b">Специальность</th>
                                <th class="py-2 px-4 border-b">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groups as $group)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $group->groupID }}</td>
                                    <td class="py-2 px-4 border-b">{{ $group->groupName }}</td>
                                    <td class="py-2 px-4 border-b">{{ $group->speciality->specialityName }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="{{ route('groups.show', $group) }}" class="text-blue-600 hover:text-blue-800 font-medium">Просмотр</a>
                                        <a href="{{ route('groups.edit', $group) }}" class="text-indigo-600 hover:text-indigo-800 font-medium ml-2">Редактировать</a>
                                        <form action="{{ route('groups.destroy', $group) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium ml-2">Удалить</button>
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

