<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventStatus extends Model
{
    public $timestamps = false;
    protected $table = 'eventStatuses';
    protected $primaryKey = 'eventStatusID';

    protected $fillable = [
        'eventStatusID',
        'eventStatus',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'eventStatuses_eventStatusID', 'eventStatusID');
    }
}
