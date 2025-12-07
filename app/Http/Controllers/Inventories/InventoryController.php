<?php

namespace App\Http\Controllers\Inventories;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryCategory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = Inventory::with('inventoryCategories')->get();
        return view('inventories.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inventoryCategories = InventoryCategory::all();
        return view('inventories.create', compact('inventoryCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nameInventory' => 'required|max:50',
            'countInventory' => 'required|integer|min:0',
            'inventoryCategories_inventoryCategoryID' => 'required|exists:inventoryCategories,inventoryCategoryID',
        ]);

        Inventory::create($request->all());

        return redirect()->route('inventories.index')
            ->with('success', 'Инвентарь успешно создан.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        $inventory->load(['inventoryCategories', 'events']);
        return view('inventories.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        $inventoryCategories = InventoryCategory::all();
        return view('inventories.edit', compact('inventory', 'inventoryCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'nameInventory' => 'required|max:50',
            'countInventory' => 'required|integer|min:0',
            'inventoryCategories_inventoryCategoryID' => 'required|exists:inventoryCategories,inventoryCategoryID',
        ]);

        $inventory->update($request->all());

        return redirect()->route('inventories.index')
            ->with('success', 'Инвентарь успешно обновлён');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventories.index')
            ->with('success', 'Инвентарь успешно удалён');
    }
}
