<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EventsStatisticsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
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
        $query = Event::with([
            'eventType',
            'eventStatus',
            'organizer',
            'faculty',
            'registrations',
            'groupRegistrations'
        ]);

        if ($this->startDate) {
            $query->where('startDateTime', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->where('startDateTime', '<=', $this->endDate . ' 23:59:59');
        }

        return $query->orderBy('startDateTime', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            '№',
            'Название мероприятия',
            'Тип мероприятия',
            'Статус',
            'Дата начала',
            'Дата окончания',
            'Место проведения',
            'Организатор',
            'Отделение',
            'Бюджет',
            'Кол-во индивидуальных регистраций',
            'Кол-во групповых регистраций',
            'Дата создания',
        ];
    }

    public function map($row): array
    {
        $this->rowNumber++;

        $organizerName = '';
        if ($row->organizer) {
            $organizerName = trim(
                $row->organizer->organizer_lastName . ' ' .
                $row->organizer->organizer_firstName . ' ' .
                ($row->organizer->organizer_middleName ?? '')
            );
        }

        return [
            $this->rowNumber,
            $row->title,
            $row->eventType?->eventType ?? 'Не указан',
            $row->eventStatus?->eventStatus ?? 'Не указан',
            $row->startDateTime ? date('d.m.Y H:i', strtotime($row->startDateTime)) : '',
            $row->endDateTime ? date('d.m.Y H:i', strtotime($row->endDateTime)) : '',
            $row->location ?? '',
            $organizerName ?: 'Не указан',
            $row->faculty?->facultyName ?? 'Общеколледжное',
            $row->budget ? number_format($row->budget, 2, ',', ' ') . ' ₽' : 'Не указан',
            $row->registrations->count(),
            $row->groupRegistrations->count(),
            $row->createdAt ? date('d.m.Y H:i', strtotime($row->createdAt)) : '',
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
        return 'Статистика мероприятий';
    }
}

