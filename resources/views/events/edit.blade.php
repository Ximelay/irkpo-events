<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Редактирование мероприятия') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('events.update', $event->eventID) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Название -->
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">
                                Название мероприятия <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror"
                                   required>
                            @error('title')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Описание -->
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">
                                Описание
                            </label>
                            <textarea name="description" id="description" rows="4"
                                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror">{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Дата и время начала -->
                        <div class="mb-4">
                            <label for="startDateTime" class="block text-gray-700 text-sm font-bold mb-2">
                                Дата и время начала <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="startDateTime" id="startDateTime"
                                   value="{{ old('startDateTime', \Carbon\Carbon::parse($event->startDateTime)->format('Y-m-d\TH:i')) }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('startDateTime') border-red-500 @enderror"
                                   required>
                            @error('startDateTime')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Дата и время окончания -->
                        <div class="mb-4">
                            <label for="endDateTime" class="block text-gray-700 text-sm font-bold mb-2">
                                Дата и время окончания <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="endDateTime" id="endDateTime"
                                   value="{{ old('endDateTime', \Carbon\Carbon::parse($event->endDateTime)->format('Y-m-d\TH:i')) }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('endDateTime') border-red-500 @enderror"
                                   required>
                            @error('endDateTime')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Место проведения -->
                        <div class="mb-4">
                            <label for="location" class="block text-gray-700 text-sm font-bold mb-2">
                                Место проведения <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('location') border-red-500 @enderror"
                                   required>
                            @error('location')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Бюджет -->
                        <div class="mb-4">
                            <label for="budget" class="block text-gray-700 text-sm font-bold mb-2">
                                Бюджет (руб.)
                            </label>
                            <input type="number" step="0.01" name="budget" id="budget" value="{{ old('budget', $event->budget) }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('budget') border-red-500 @enderror">
                            @error('budget')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Тип мероприятия -->
                        <div class="mb-4">
                            <label for="eventTypes_eventTypeID" class="block text-gray-700 text-sm font-bold mb-2">
                                Тип мероприятия
                            </label>
                            <select name="eventTypes_eventTypeID" id="eventTypes_eventTypeID"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('eventTypes_eventTypeID') border-red-500 @enderror">
                                <option value="">Выберите тип</option>
                                @foreach($eventTypes as $type)
                                    <option value="{{ $type->eventTypeID }}"
                                        {{ old('eventTypes_eventTypeID', $event->eventTypes_eventTypeID) == $type->eventTypeID ? 'selected' : '' }}>
                                        {{ $type->eventType }}
                                    </option>
                                @endforeach
                            </select>
                            @error('eventTypes_eventTypeID')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Статус мероприятия -->
                        <div class="mb-4">
                            <label for="eventStatuses_eventStatusID" class="block text-gray-700 text-sm font-bold mb-2">
                                Статус мероприятия
                            </label>
                            <select name="eventStatuses_eventStatusID" id="eventStatuses_eventStatusID"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('eventStatuses_eventStatusID') border-red-500 @enderror">
                                <option value="">Выберите статус</option>
                                @foreach($eventStatuses as $status)
                                    <option value="{{ $status->eventStatusID }}"
                                        {{ old('eventStatuses_eventStatusID', $event->eventStatuses_eventStatusID) == $status->eventStatusID ? 'selected' : '' }}>
                                        {{ $status->eventStatus }}
                                    </option>
                                @endforeach
                            </select>
                            @error('eventStatuses_eventStatusID')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Отделение -->
                        <div class="mb-4">
                            <label for="faculties_facultyID" class="block text-gray-700 text-sm font-bold mb-2">
                                Отделение
                            </label>
                            <select name="faculties_facultyID" id="faculties_facultyID"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('faculties_facultyID') border-red-500 @enderror">
                                <option value="">Выберите отделение</option>
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->facultyID }}"
                                        {{ old('faculties_facultyID', $event->faculties_facultyID) == $faculty->facultyID ? 'selected' : '' }}>
                                        {{ $faculty->facultyName }}
                                    </option>
                                @endforeach
                            </select>
                            @error('faculties_facultyID')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Организатор -->
                        <div class="mb-4">
                            <label for="organizers_organizerID" class="block text-gray-700 text-sm font-bold mb-2">
                                Организатор <span class="text-red-500">*</span>
                            </label>
                            <select name="organizers_organizerID" id="organizers_organizerID"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('organizers_organizerID') border-red-500 @enderror"
                                    required>
                                <option value="">Выберите организатора</option>
                                @foreach($organizers as $organizer)
                                    <option value="{{ $organizer->organizerID }}"
                                        {{ old('organizers_organizerID', $event->organizers_organizerID) == $organizer->organizerID ? 'selected' : '' }}>
                                        {{ $organizer->organizer_lastName }} {{ $organizer->organizer_firstName }} {{ $organizer->organizer_middleName }}
                                    </option>
                                @endforeach
                            </select>
                            @error('organizers_organizerID')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Кнопки -->
                        <div class="flex items-center justify-between mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Сохранить изменения
                            </button>
                            <a href="{{ route('events.show', $event->eventID) }}" class="text-gray-600 hover:text-gray-800">
                                Отмена
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

