<?php

namespace App\Http\Controllers;

use App\Models\InventoryCategory;
use Illuminate\Http\Request;

class InventoryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventoryCategories = InventoryCategory::all();
        return view('inventory-categories.index', compact('inventoryCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nameInventoryCategory' => 'required|unique:inventoryCategories,nameInventoryCategory|max:50',
        ]);

        InventoryCategory::create($request->all());

        return redirect()->route('inventory-categories.index')
            ->with('success', 'Inventory category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryCategory $inventoryCategory)
    {
        return view('inventory-categories.show', compact('inventoryCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryCategory $inventoryCategory)
    {
        return view('inventory-categories.edit', compact('inventoryCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryCategory $inventoryCategory)
    {
        $request->validate([
            'nameInventoryCategory' => 'required|max:50|unique:inventoryCategories,nameInventoryCategory,' . $inventoryCategory->inventoryCategoryID . ',inventoryCategoryID',
        ]);

        $inventoryCategory->update($request->all());

        return redirect()->route('inventory-categories.index')
            ->with('success', 'Inventory category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryCategory $inventoryCategory)
    {
        $inventoryCategory->delete();

        return redirect()->route('inventory-categories.index')
            ->with('success', 'Inventory category deleted successfully');
    }
}
