<?php

namespace App\Http\Controllers\Reports;

use App\Exports\EventsStatisticsExport;
use App\Exports\GroupParticipationExport;
use App\Exports\OrganizerStatisticsExport;
use App\Exports\StudentParticipationExport;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Показать страницу с выбором отчётов
     */
    public function index()
    {
        $groups = Group::with('speciality')->orderBy('groupName')->get();
        $students = User::with('group')->orderBy('user_lastName')->orderBy('user_firstName')->get();

        return view('reports.index', compact('groups', 'students'));
    }

    /**
     * Экспорт отчёта об участии групп в мероприятиях
     */
    public function exportGroupParticipation(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $filename = 'участие_групп_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new GroupParticipationExport($startDate, $endDate),
            $filename
        );
    }

    /**
     * Экспорт отчёта об участии студентов в мероприятиях
     */
    public function exportStudentParticipation(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'student_id' => 'nullable|exists:users,userID',
            'group_id' => 'nullable|exists:groups,groupID',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $studentId = $request->input('student_id');
        $groupId = $request->input('group_id');

        $filename = 'участие_студентов_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new StudentParticipationExport($startDate, $endDate, $studentId, $groupId),
            $filename
        );
    }

    /**
     * Экспорт статистики по мероприятиям
     */
    public function exportEventsStatistics(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $filename = 'статистика_мероприятий_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new EventsStatisticsExport($startDate, $endDate),
            $filename
        );
    }

    /**
     * Экспорт статистики по организаторам
     */
    public function exportOrganizerStatistics(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $filename = 'статистика_организаторов_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new OrganizerStatisticsExport($startDate, $endDate),
            $filename
        );
    }
}

