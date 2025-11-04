<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventType extends Model
{
    public $timestamps = false;
    protected $table = 'eventTypes';
    protected $primaryKey = 'eventTypeID';

    protected $fillable = [
        'eventTypeID',
        'eventType',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'eventTypes_eventTypeID', 'eventTypeID');
    }
}
