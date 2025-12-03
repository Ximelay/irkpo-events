<?php

namespace App\Http\Controllers\Faculties;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specialties = Specialty::with('faculty')->get();
        return view('specialties.index', compact('specialties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faculties = Faculty::all();
        return view('specialties.create', compact('faculties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'specialityName' => 'required|max:50',
            'specialityCode' => 'required|max:50|unique:specialties,specialityCode',
            'faculties_facultyID' => 'required|exists:faculties,facultyID',
        ]);

        Specialty::create($request->all());

        return redirect()->route('specialties.index')
            ->with('success', 'Specialty created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialty $specialty)
    {
        return view('specialties.show', compact('specialty'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialty $specialty)
    {
        $faculties = Faculty::all();
        return view('specialties.edit', compact('specialty', 'faculties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Specialty $specialty)
    {
        $request->validate([
            'specialityName' => 'required|max:50',
            'specialityCode' => 'required|max:50|unique:specialties,specialityCode,' . $specialty->specialityID . ',specialityID',
            'faculties_facultyID' => 'required|exists:faculties,facultyID',
        ]);

        $specialty->update($request->all());

        return redirect()->route('specialties.index')
            ->with('success', 'Specialty updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialty $specialty)
    {
        $specialty->delete();

        return redirect()->route('specialties.index')
            ->with('success', 'Specialty deleted successfully');
    }
}
