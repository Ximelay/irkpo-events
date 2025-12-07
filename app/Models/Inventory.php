<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inventory extends Model
{
    public $timestamps = false;
    protected $table = 'inventories';
    protected $primaryKey = 'inventoryID';

    protected $fillable = [
        'inventoryID',
        'nameInventory',
        'countInventory',
        'inventoryCategories_inventoryCategoryID',
    ];

    /**
     * Получить имя ключа маршрута для модели.
     */
    public function getRouteKeyName(): string
    {
        return 'inventoryID';
    }

    public function inventoryCategories(): BelongsTo
    {
        return $this->belongsTo(InventoryCategory::class, 'inventoryCategories_inventoryCategoryID', 'inventoryCategoryID');
    }

    /**
     * Связь с назначениями инвентаря на мероприятия
     */
    public function eventInventories(): HasMany
    {
        return $this->hasMany(EventInventory::class, 'inventories_inventoryID', 'inventoryID');
    }

    /**
     * Получить мероприятия, использующие этот инвентарь
     */
    public function events()
    {
        return $this->belongsToMany(
            Event::class,
            'eventInventory',
            'inventories_inventoryID',
            'events_eventID',
            'inventoryID',
            'eventID'
        )->withPivot('quantity', 'addedAt');
    }
}
