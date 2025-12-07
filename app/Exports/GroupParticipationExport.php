<?php

namespace App\Exports;

use App\Models\EventGroupRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GroupParticipationExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $startDate;
    protected $endDate;
    protected $rowNumber = 0;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = EventGroupRegistration::with(['event', 'group.speciality.faculty'])
            ->whereHas('event');

        if ($this->startDate) {
            $query->whereHas('event', function ($q) {
                $q->where('startDateTime', '>=', $this->startDate);
            });
        }

        if ($this->endDate) {
            $query->whereHas('event', function ($q) {
                $q->where('startDateTime', '<=', $this->endDate . ' 23:59:59');
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            '№',
            'Группа',
            'Специальность',
            'Отделение',
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
            $row->group?->groupName ?? 'Не указана',
            $row->group?->speciality?->specialityName ?? 'Не указана',
            $row->group?->speciality?->faculty?->facultyName ?? 'Не указано',
            $row->event?->title ?? 'Не указано',
            $row->event?->startDateTime ? date('d.m.Y H:i', strtotime($row->event->startDateTime)) : '',
            $row->event?->location ?? '',
            $row->registrationDate ? date('d.m.Y H:i', strtotime($row->registrationDate)) : '',
            $this->getStatusText($row->statusGroupRegistration),
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
        return 'Участие групп';
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
