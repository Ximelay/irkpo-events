<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faculties = Faculty::all();
        return view('faculties.index', compact('faculties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('faculties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'facultyName' => 'required|unique:faculties|max:100',
            'facultyHead' => 'required|max:150',
        ]);

        Faculty::create($request->all());

        return redirect()->route('faculties.index')
            ->with('success', 'Faculty created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faculty $faculty)
    {
        return view('faculties.show', compact('faculty'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faculty $faculty)
    {
        return view('faculties.edit', compact('faculty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faculty $faculty)
    {
        $request->validate([
            'facultyName' => 'required|max:100|unique:faculties,facultyName,' . $faculty->facultyID . ',facultyID',
            'facultyHead' => 'required|max:150',
        ]);

        $faculty->update($request->all());

        return redirect()->route('faculties.index')
            ->with('success', 'Faculty updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faculty $faculty)
    {
        $faculty->delete();

        return redirect()->route('faculties.index')
            ->with('success', 'Faculty deleted successfully');
    }
}
