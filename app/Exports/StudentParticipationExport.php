<?php

namespace App\Exports;

use App\Models\EventRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentParticipationExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $startDate;
    protected $endDate;
    protected $studentId;
    protected $groupId;
    protected $rowNumber = 0;

    public function __construct($startDate = null, $endDate = null, $studentId = null, $groupId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->studentId = $studentId;
        $this->groupId = $groupId;
    }

    public function collection()
    {
        $query = EventRegistration::with(['event', 'user.group.speciality.faculty'])
            ->whereHas('event')
            ->whereHas('user');

        // Фильтр по конкретному студенту
        if ($this->studentId) {
            $query->where('users_userID', $this->studentId);
        }

        // Фильтр по группе
        if ($this->groupId) {
            $query->whereHas('user', function ($q) {
                $q->where('groups_groupID', $this->groupId);
            });
        }

        // Фильтр по дате начала мероприятия
        if ($this->startDate) {
            $query->whereHas('event', function ($q) {
                $q->where('startDateTime', '>=', $this->startDate);
            });
        }

        // Фильтр по дате окончания мероприятия
        if ($this->endDate) {
            $query->whereHas('event', function ($q) {
                $q->where('startDateTime', '<=', $this->endDate . ' 23:59:59');
            });
        }

        return $query->orderBy('registrationDate', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            '№',
            'Фамилия',
            'Имя',
            'Отчество',
            'Группа',
            'Специальность',
            'Отделение',
            'Email',
            'Мероприятие',
            'Дата мероприятия',
            'Место проведения',
            'Дата регистрации',
            'Статус регистрации',
        ];
    }

    public function map($row): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $row->user?->user_lastName ?? 'Не указана',
            $row->user?->user_firstName ?? 'Не указано',
            $row->user?->user_middleName ?? '',
            $row->user?->group?->groupName ?? 'Не указана',
            $row->user?->group?->speciality?->specialityName ?? 'Не указана',
            $row->user?->group?->speciality?->faculty?->facultyName ?? 'Не указано',
            $row->user?->user_email ?? '',
            $row->event?->title ?? 'Не указано',
            $row->event?->startDateTime ? date('d.m.Y H:i', strtotime($row->event->startDateTime)) : '',
            $row->event?->location ?? '',
            $row->registrationDate ? date('d.m.Y H:i', strtotime($row->registrationDate)) : '',
            $this->getStatusText($row->statusEventRegistration),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    public function title(): string
    {
        return 'Участие студентов';
    }

    protected function getStatusText($status): string
    {
        return match ($status) {
            'active' => 'Активна',
            'cancelled' => 'Отменена',
            'completed' => 'Завершена',
            default => $status,
        };
    }
}

