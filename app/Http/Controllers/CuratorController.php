<?php

namespace App\Http\Controllers;

use App\Models\Curator;
use App\Models\Group;
use Illuminate\Http\Request;

class CuratorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $curators = Curator::with('groups')->get();
        return view('curators.index', compact('curators'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = Group::all();
        return view('curators.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'curator_firstName' => 'required|max:50',
            'curator_lastName' => 'required|max:50',
            'curator_middleName' => 'nullable|max:50',
            'groups_groupID' => 'required|exists:groups,groupID',
        ]);

        Curator::create($request->all());

        return redirect()->route('curators.index')
            ->with('success', 'Curator created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Curator $curator)
    {
        return view('curators.show', compact('curator'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curator $curator)
    {
        $groups = Group::all();
        return view('curators.edit', compact('curator', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curator $curator)
    {
        $request->validate([
            'curator_firstName' => 'required|max:50',
            'curator_lastName' => 'required|max:50',
            'curator_middleName' => 'nullable|max:50',
            'groups_groupID' => 'required|exists:groups,groupID',
        ]);

        $curator->update($request->all());

        return redirect()->route('curators.index')
            ->with('success', 'Curator updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curator $curator)
    {
        $curator->delete();

        return redirect()->route('curators.index')
            ->with('success', 'Curator deleted successfully');
    }
}
