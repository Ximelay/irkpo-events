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
        'eventStatuses_eventStatusID',
        'users_OrganizerID',
        'faculties_facultyID',
    ];

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
        return $this->belongsTo(User::class, 'users_OrganizerID', 'userID');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculties_facultyID', 'facultyID');
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class, 'events_eventID', 'eventID');
    }

    public function expenses()
    {
        return $this->hasMany(EventExpense::class, 'events_eventID', 'eventID');
    }
}
