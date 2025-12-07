<?php

namespace App\Exports;

use App\Models\Organizer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrganizerStatisticsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
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
        $startDate = $this->startDate;
        $endDate = $this->endDate;

        $query = Organizer::withCount(['events' => function ($query) use ($startDate, $endDate) {
            if ($startDate) {
                $query->where('startDateTime', '>=', $startDate);
            }
            if ($endDate) {
                $query->where('startDateTime', '<=', $endDate . ' 23:59:59');
            }
        }])->with(['events' => function ($query) use ($startDate, $endDate) {
            if ($startDate) {
                $query->where('startDateTime', '>=', $startDate);
            }
            if ($endDate) {
                $query->where('startDateTime', '<=', $endDate . ' 23:59:59');
            }
            $query->with('eventStatus');
        }]);

        return $query->get();
    }

    public function headings(): array
    {
        return [
            '№',
            'Фамилия',
            'Имя',
            'Отчество',
            'Должность',
            'Всего мероприятий',
            'Запланировано',
            'Проведено',
            'Отменено',
            'Общий бюджет мероприятий',
        ];
    }

    public function map($row): array
    {
        $this->rowNumber++;

        $planned = $row->events->filter(fn($e) => $e->eventStatus?->eventStatus === 'planned')->count();
        $completed = $row->events->filter(fn($e) => $e->eventStatus?->eventStatus === 'completed')->count();
        $cancelled = $row->events->filter(fn($e) => $e->eventStatus?->eventStatus === 'cancelled')->count();
        $totalBudget = $row->events->sum('budget');

        return [
            $this->rowNumber,
            $row->organizer_lastName,
            $row->organizer_firstName,
            $row->organizer_middleName ?? '',
            $row->jobTitle ?? '',
            $row->events_count,
            $planned,
            $completed,
            $cancelled,
            $totalBudget ? number_format($totalBudget, 2, ',', ' ') . ' ₽' : '0 ₽',
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
        return 'Статистика организаторов';
    }
}

