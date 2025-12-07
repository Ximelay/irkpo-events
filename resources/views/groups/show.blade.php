<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Просмотр группы: {{ $group->groupName }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Основная информация о группе -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Информация о группе</h3>
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
                    <div class="mb-4">
                        <strong class="text-gray-700">Код специальности:</strong>
                        <p class="text-gray-900">{{ $group->speciality->specialityCode }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="text-gray-700">Количество студентов:</strong>
                        <p class="text-gray-900">{{ $group->users->count() }}</p>
                    </div>
                    <a href="{{ route('groups.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">Назад к списку</a>
                </div>
            </div>

            <!-- Форма массового импорта студентов -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Массовое добавление студентов</h3>

                    <!-- Инструкция -->
                    <details class="mb-4 p-4 bg-blue-50 rounded">
                        <summary class="cursor-pointer font-semibold text-blue-800">📋 Инструкция по формату файла (нажмите, чтобы раскрыть)</summary>
                        <div class="mt-3 text-sm text-gray-700">
                            <p class="mb-2"><strong>Файл Excel должен содержать две колонки:</strong></p>
                            <ul class="list-disc list-inside mb-3">
                                <li><strong>№</strong> - порядковый номер студента</li>
                                <li><strong>ФИО</strong> - полное ФИО студента в формате "Фамилия Имя Отчество"</li>
                            </ul>
                            <p class="mb-2"><strong>Пример таблицы:</strong></p>
                            <div class="bg-white p-2 rounded border border-gray-300 overflow-x-auto">
                                <table class="text-xs">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="border px-2 py-1">№</th>
                                            <th class="border px-2 py-1">ФИО</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border px-2 py-1 text-center">1</td>
                                            <td class="border px-2 py-1">Иванов Иван Иванович</td>
                                        </tr>
                                        <tr>
                                            <td class="border px-2 py-1 text-center">2</td>
                                            <td class="border px-2 py-1">Петрова Мария Сергеевна</td>
                                        </tr>
                                        <tr>
                                            <td class="border px-2 py-1 text-center">3</td>
                                            <td class="border px-2 py-1">Сидоров Петр Александрович</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="mt-3 text-xs text-gray-600">
                                ℹ️ <strong>Формат ФИО:</strong> Фамилия Имя Отчество (через пробел)<br>
                                ℹ️ <strong>Email генерируется автоматически:</strong> фамилия.и@student.irkpo.ru<br>
                                ℹ️ Студенты с одинаковыми ФИО в одной группе будут пропущены как дубликаты<br>
                                ℹ️ Максимальный размер файла: 2 МБ<br>
                                ℹ️ Поддерживаемые форматы: .xlsx, .xls
                            </p>
                            <p class="mt-2 text-xs bg-yellow-50 border-l-4 border-yellow-400 p-2">
                                <strong>⚠️ Важно:</strong> Первая строка должна содержать заголовки (№ и ФИО)
                            </p>
                        </div>
                    </details>

                    <form action="{{ route('groups.importStudents', $group->groupID) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="students_file" class="block text-gray-700 text-sm font-bold mb-2">
                                Выберите Excel файл со списком студентов:
                            </label>
                            <input type="file"
                                   name="students_file"
                                   id="students_file"
                                   accept=".xlsx,.xls"
                                   class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('students_file') border-red-500 @enderror"
                                   required>
                            @error('students_file')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Импортировать студентов
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Список студентов группы -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Студенты группы</h3>
                    @if($group->users->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">№</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Фамилия</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Имя</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Отчество</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($group->users as $index => $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $index + 1 }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->user_lastName }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $user->user_firstName }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $user->user_middleName ?? '-' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $user->user_email ?? '-' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('users.show', $user->userID) }}" class="text-blue-600 hover:text-blue-900 mr-3">Просмотр</a>
                                                <a href="{{ route('users.edit', $user->userID) }}" class="text-indigo-600 hover:text-indigo-900">Редактировать</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">В группе пока нет студентов. Используйте форму выше для импорта.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

