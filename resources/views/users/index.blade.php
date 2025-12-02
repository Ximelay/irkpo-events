<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Пользователи
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Список пользователей</h3>
                        <a href="{{ route('users.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Добавить пользователя
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
                                <th class="py-2 px-4 border-b">ФИО</th>
                                <th class="py-2 px-4 border-b">Email</th>
                                <th class="py-2 px-4 border-b">Группа</th>
                                <th class="py-2 px-4 border-b">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $user->userID }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->user_lastName }} {{ $user->user_firstName }} {{ $user->user_middleName }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->user_email }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->group->groupName ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="{{ route('users.show', $user) }}" class="text-blue-500 hover:underline">Просмотр</a>
                                        <a href="{{ route('users.edit', $user) }}" class="text-yellow-500 hover:underline ml-2">Редактировать</a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
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

