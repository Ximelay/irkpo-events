<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\Group;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::with('speciality')->get();
        return view('groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specialties = Specialty::all();
        return view('groups.create', compact('specialties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'groupName' => 'required|max:50',
            'specialties_specialityID' => 'required|exists:specialties,specialityID',
        ]);

        Group::create($request->all());

        return redirect()->route('groups.index')
            ->with('success', 'Group created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        $group->load(['users', 'speciality']);
        return view('groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        $specialties = Specialty::all();
        return view('groups.edit', compact('group', 'specialties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'groupName' => 'required|max:50',
            'specialties_specialityID' => 'required|exists:specialties,specialityID',
        ]);

        $group->update($request->all());

        return redirect()->route('groups.index')
            ->with('success', 'Group updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->delete();

        return redirect()->route('groups.index')
            ->with('success', 'Group deleted successfully');
    }

    /**
     * Массовый импорт студентов из Excel файла
     */
    public function importStudents(Request $request, Group $group)
    {
        $request->validate([
            'students_file' => 'required|file|mimes:xlsx,xls|max:2048',
        ], [
            'students_file.required' => 'Необходимо выбрать файл для импорта',
            'students_file.mimes' => 'Файл должен быть в формате Excel (xlsx, xls)',
            'students_file.max' => 'Размер файла не должен превышать 2 МБ',
        ]);

        try {
            $import = new StudentsImport($group->groupID);
            Excel::import($import, $request->file('students_file'));

            $importedCount = $import->getImportedCount();
            $skippedCount = $import->getSkippedCount();
            $errors = $import->getErrors();

            $message = "Успешно импортировано студентов: {$importedCount}";
            if ($skippedCount > 0) {
                $message .= ". Пропущено (дубликаты или ошибки): {$skippedCount}";
            }

            if (!empty($errors)) {
                $message .= "\n\nОшибки парсинга:\n" . implode("\n", array_slice($errors, 0, 5));
                if (count($errors) > 5) {
                    $message .= "\n... и ещё " . (count($errors) - 5) . " ошибок";
                }
            }

            return redirect()->route('groups.show', $group->groupID)
                ->with('success', $message);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Строка {$failure->row()}: " . implode(', ', $failure->errors());
            }

            return redirect()->route('groups.show', $group->groupID)
                ->with('error', 'Ошибки валидации: ' . implode(' | ', $errors));
        } catch (\Exception $e) {
            return redirect()->route('groups.show', $group->groupID)
                ->with('error', 'Ошибка при импорте: ' . $e->getMessage());
        }
    }
}
