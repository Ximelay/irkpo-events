<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Отчёты
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Информация о периоде -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Фильтр по периоду</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Выберите период для формирования отчётов. Если период не указан, будут выгружены все данные.
                    </p>
                    <form id="reportForm" class="space-y-4">
                        <div class="flex flex-wrap gap-4 items-end">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Дата начала</label>
                                <input type="date" name="start_date" id="start_date"
                                       class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Дата окончания</label>
                                <input type="date" name="end_date" id="end_date"
                                       class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <button type="button" onclick="clearDates()"
                                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                                    Сбросить даты
                                </button>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <h4 class="text-sm font-semibold text-gray-900 mb-3">Фильтр для отчёта по студентам</h4>
                            <div class="flex flex-wrap gap-4 items-end">
                                <div class="flex-1 min-w-[250px]">
                                    <label for="group_id" class="block text-sm font-medium text-gray-700 mb-1">Группа</label>
                                    <select name="group_id" id="group_id"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            onchange="filterStudentsByGroup()">
                                        <option value="">Все группы</option>
                                        @foreach($groups as $group)
                                            <option value="{{ $group->groupID }}">
                                                {{ $group->groupName }} - {{ $group->speciality?->specialityName ?? '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex-1 min-w-[250px]">
                                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Студент</label>
                                    <select name="student_id" id="student_id"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Все студенты</option>
                                        @foreach($students as $student)
                                            <option value="{{ $student->userID }}" data-group="{{ $student->groups_groupID }}">
                                                {{ $student->user_lastName }} {{ $student->user_firstName }} {{ $student->user_middleName }}
                                                ({{ $student->group?->groupName ?? 'Без группы' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <button type="button" onclick="clearStudentFilters()"
                                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                                        Сбросить фильтры
                                    </button>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                Выберите группу и/или конкретного студента для индивидуального отчёта
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Отчёты -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Отчёт по группам -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Участие групп в мероприятиях</h3>
                                <p class="text-sm text-gray-500">Какие группы принимали участие в мероприятиях</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">
                            Отчёт содержит информацию о группах, зарегистрированных на мероприятия, включая специальность, отделение, дату мероприятия и статус регистрации.
                        </p>
                        <button onclick="downloadReport('{{ route('reports.groups') }}')"
                                class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition flex items-center justify-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Скачать Excel
                        </button>
                    </div>
                </div>

                <!-- Отчёт по студентам -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Участие студентов в мероприятиях</h3>
                                <p class="text-sm text-gray-500">Какие студенты принимали участие в мероприятиях</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">
                            Отчёт содержит информацию о студентах, зарегистрированных на мероприятия индивидуально, включая ФИО, группу, специальность и данные о мероприятии.
                        </p>
                        <button onclick="downloadReport('{{ route('reports.students') }}', true)"
                                class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition flex items-center justify-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Скачать Excel
                        </button>
                    </div>
                </div>

                <!-- Статистика мероприятий -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Статистика мероприятий</h3>
                                <p class="text-sm text-gray-500">Сводная информация по всем мероприятиям</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">
                            Отчёт содержит полную статистику по мероприятиям: название, тип, статус, даты, организатор, бюджет и количество регистраций.
                        </p>
                        <button onclick="downloadReport('{{ route('reports.events') }}')"
                                class="w-full px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition flex items-center justify-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Скачать Excel
                        </button>
                    </div>
                </div>

                <!-- Статистика организаторов -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 h-12 w-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Статистика организаторов</h3>
                                <p class="text-sm text-gray-500">Сколько мероприятий провёл каждый организатор</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">
                            Отчёт содержит информацию о работе организаторов: ФИО, должность, количество проведённых, запланированных и отменённых мероприятий, общий бюджет.
                        </p>
                        <button onclick="downloadReport('{{ route('reports.organizers') }}')"
                                class="w-full px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 transition flex items-center justify-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Скачать Excel
                        </button>
                    </div>
                </div>
            </div>

            <!-- Подсказка -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Подсказка</h3>
                        <p class="mt-1 text-sm text-blue-700">
                            Файлы скачиваются в формате Excel (.xlsx) и могут быть открыты в Microsoft Excel, LibreOffice Calc, Google Sheets и других табличных редакторах.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function downloadReport(baseUrl, includeStudentFilters = false) {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            let url = baseUrl;
            const params = new URLSearchParams();

            if (startDate) {
                params.append('start_date', startDate);
            }
            if (endDate) {
                params.append('end_date', endDate);
            }

            // Добавляем фильтры по студентам только для отчёта по студентам
            if (includeStudentFilters) {
                const studentId = document.getElementById('student_id').value;
                const groupId = document.getElementById('group_id').value;

                if (studentId) {
                    params.append('student_id', studentId);
                }
                if (groupId) {
                    params.append('group_id', groupId);
                }
            }

            if (params.toString()) {
                url += '?' + params.toString();
            }

            window.location.href = url;
        }

        function clearDates() {
            document.getElementById('start_date').value = '';
            document.getElementById('end_date').value = '';
        }

        function clearStudentFilters() {
            document.getElementById('student_id').value = '';
            document.getElementById('group_id').value = '';
            // Показать все опции студентов
            const studentSelect = document.getElementById('student_id');
            Array.from(studentSelect.options).forEach(option => {
                option.style.display = '';
            });
        }

        function filterStudentsByGroup() {
            const groupId = document.getElementById('group_id').value;
            const studentSelect = document.getElementById('student_id');

            // Сбросить выбор студента
            studentSelect.value = '';

            // Фильтровать студентов
            Array.from(studentSelect.options).forEach(option => {
                if (option.value === '') {
                    option.style.display = '';
                    return;
                }

                if (!groupId || option.dataset.group === groupId) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });
        }
    </script>
</x-app-layout>

