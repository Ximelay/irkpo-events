<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryCategory extends Model
{
    public $timestamps = false;

    protected $table = 'inventoryCategories';
    protected $primaryKey = 'inventoryCategoryID';

    protected $fillable = [
        'inventoryCategoryID',
        'nameInventoryCategory',
    ];

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'inventoryCategories_inventoryCategoryID', 'inventoryCategoryID');
    }
}
