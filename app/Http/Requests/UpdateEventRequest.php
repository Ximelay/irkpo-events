<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Определяет, авторизован ли пользователь для выполнения этого запроса
     */
    public function authorize(): bool
    {
        return auth()->check(); // Измените на проверку прав доступа при необходимости
    }

    /**
     * Правила валидации для обновления мероприятия
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'startDateTime' => 'required|date',
            'endDateTime' => 'required|date|after:startDateTime',
            'location' => 'required|string|max:255',
            'budget' => 'nullable|numeric|min:0|max:99999999.99',
            'eventTypes_eventTypeID' => 'nullable|exists:eventTypes,eventTypeID',
            'eventStatuses_eventStatusID' => 'nullable|exists:eventStatuses,eventStatusID',
            'faculties_facultyID' => 'nullable|exists:faculties,facultyID',
            'organizers_organizerID' => 'required|exists:organizers,organizerID',
        ];
    }

    /**
     * Пользовательские сообщения об ошибках
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Название мероприятия обязательно для заполнения',
            'title.max' => 'Название не должно превышать 100 символов',
            'startDateTime.required' => 'Дата и время начала обязательны',
            'startDateTime.date' => 'Неверный формат даты начала',
            'endDateTime.required' => 'Дата и время окончания обязательны',
            'endDateTime.date' => 'Неверный формат даты окончания',
            'endDateTime.after' => 'Дата окончания должна быть после даты начала',
            'location.required' => 'Место проведения обязательно для заполнения',
            'location.max' => 'Место проведения не должно превышать 255 символов',
            'budget.numeric' => 'Бюджет должен быть числом',
            'budget.min' => 'Бюджет не может быть отрицательным',
            'organizers_organizerID.required' => 'Необходимо выбрать организатора',
            'organizers_organizerID.exists' => 'Выбранный организатор не существует',
        ];
    }
}

