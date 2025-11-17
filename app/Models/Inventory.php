<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'inventoryID',
        'nameInventory',
        'countInventory',
        'inventoryCategories_inventoryCategoryID',
        'events_eventID',
    ];

    public function inventoryCategories(): BelongsTo
    {
        return $this->belongsTo(InventoryCategory::class, 'inventoryCategories_inventoryCategoryID', 'inventoryCategoryID');
    }

    public function events(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'events_eventID', 'eventID');
    }
}
