<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventRegistration extends Model
{
    public $timestamps = false;

    protected $table = 'eventRegistrations';
    protected $primaryKey = 'registrationID';

    protected $fillable = [
        'registrationID',
        'registrationDate',
        'statusEventRegistration',
        'events_eventID',
        'users_userID',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'events_eventID', 'eventID');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_userID', 'userID');
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class, 'registrationID', 'registrationID');
    }
}
