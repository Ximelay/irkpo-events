<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    public $timestamps = false;
    protected $table = 'events';
    protected $primaryKey = 'eventID';

    protected $fillable = [
        'eventID',
        'title',
        'description',
        'startDateTime',
        'endDateTime',
        'location',
        'budget',
        'createdAt',
        'eventTypes_eventTypeID',
        'organizers_organizerID',
        'eventStatuses_eventStatusID',
        'faculties_facultyID',
    ];

    /**
     * Получить имя ключа маршрута для модели.
     */
    public function getRouteKeyName(): string
    {
        return 'eventID';
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class, 'eventTypes_eventTypeID', 'eventTypeID');
    }

    public function eventStatus()
    {
        return $this->belongsTo(EventStatus::class, 'eventStatuses_eventStatusID', 'eventStatusID');
    }

    public function organizer()
    {
        return $this->belongsTo(Organizer::class, 'organizers_organizerID', 'organizerID');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculties_facultyID', 'facultyID');
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class, 'events_eventID', 'eventID');
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'events_eventID', 'eventID');
    }
}
