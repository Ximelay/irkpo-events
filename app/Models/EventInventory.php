<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventInventory extends Model
{
    public $timestamps = false;
    protected $table = 'eventInventory';
    protected $primaryKey = 'eventInventoryID';

    protected $fillable = [
        'events_eventID',
        'inventories_inventoryID',
        'quantity',
        'addedAt',
    ];

    protected $casts = [
        'addedAt' => 'datetime',
        'quantity' => 'integer',
    ];

    /**
     * Получить имя ключа маршрута для модели.
     */
    public function getRouteKeyName(): string
    {
        return 'eventInventoryID';
    }

    /**
     * Связь с мероприятием
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'events_eventID', 'eventID');
    }

    /**
     * Связь с инвентарем
     */
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'inventories_inventoryID', 'inventoryID');
    }
}
