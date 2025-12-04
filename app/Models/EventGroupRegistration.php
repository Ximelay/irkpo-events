<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventGroupRegistration extends Model
{
    public $timestamps = false;

    protected $table = 'eventGroupRegistrations';
    protected $primaryKey = 'groupRegistrationID';

    protected $fillable = [
        'groupRegistrationID',
        'registrationDate',
        'statusGroupRegistration',
        'events_eventID',
        'groups_groupID',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'events_eventID', 'eventID');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'groups_groupID', 'groupID');
    }

    /**
     * Проверить, участвует ли студент в мероприятии через свою группу
     */
    public static function isUserParticipatingThroughGroup(int $eventId, int $userId): bool
    {
        $user = User::find($userId);

        if (!$user || !$user->groups_groupID) {
            return false;
        }

        return self::where('events_eventID', $eventId)
            ->where('groups_groupID', $user->groups_groupID)
            ->where('statusGroupRegistration', 'active')
            ->exists();
    }

    /**
     * Получить регистрацию группы для студента на определённое мероприятие
     */
    public static function getGroupRegistrationForUser(int $eventId, int $userId): ?self
    {
        $user = User::find($userId);

        if (!$user || !$user->groups_groupID) {
            return null;
        }

        return self::where('events_eventID', $eventId)
            ->where('groups_groupID', $user->groups_groupID)
            ->first();
    }
}

