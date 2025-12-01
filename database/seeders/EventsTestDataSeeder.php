<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsTestDataSeeder extends Seeder
{
    /**
     * Заполнение базы данных тестовыми данными для мероприятий
     */
    public function run(): void
    {
        // Типы мероприятий
        $eventTypes = [
            ['eventType' => 'Спортивное'],
            ['eventType' => 'Культурное'],
            ['eventType' => 'Образовательное'],
            ['eventType' => 'Научное'],
            ['eventType' => 'Воспитательное'],
        ];

        foreach ($eventTypes as $type) {
            DB::table('eventTypes')->insertOrIgnore($type);
        }

        // Статусы мероприятий
        $eventStatuses = [
            ['eventStatus' => 'planned'],
            ['eventStatus' => 'ongoing'],
            ['eventStatus' => 'completed'],
            ['eventStatus' => 'cancelled'],
        ];

        foreach ($eventStatuses as $status) {
            DB::table('eventStatuses')->insertOrIgnore($status);
        }

        // Отделения
        $faculties = [
            ['facultyName' => 'Информационных технологий', 'facultyHead' => 'Иванов Иван Иванович'],
            ['facultyName' => 'Экономики и менеджмента', 'facultyHead' => 'Петров Петр Петрович'],
            ['facultyName' => 'Строительства', 'facultyHead' => 'Сидоров Сидор Сидорович'],
        ];

        foreach ($faculties as $faculty) {
            DB::table('faculties')->insertOrIgnore($faculty);
        }

        // Организаторы
        $organizers = [
            [
                'organizer_firstName' => 'Анна',
                'organizer_lastName' => 'Кузнецова',
                'organizer_middleName' => 'Сергеевна',
                'jobTitle' => 'Заместитель директора по воспитательной работе',
            ],
            [
                'organizer_firstName' => 'Михаил',
                'organizer_lastName' => 'Смирнов',
                'organizer_middleName' => 'Александрович',
                'jobTitle' => 'Руководитель студенческого совета',
            ],
            [
                'organizer_firstName' => 'Елена',
                'organizer_lastName' => 'Волкова',
                'organizer_middleName' => 'Дмитриевна',
                'jobTitle' => 'Преподаватель физической культуры',
            ],
        ];

        foreach ($organizers as $organizer) {
            DB::table('organizers')->insertOrIgnore($organizer);
        }

        $this->command->info('Тестовые данные для мероприятий успешно добавлены!');
    }
}

