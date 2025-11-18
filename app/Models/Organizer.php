<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organizer extends Model
{
    public $timestamps = false;
    protected $table = 'organizers';
    protected $primaryKey = 'organizerID';

    protected $fillable = [
        'organizerID',
        'organizer_firstName',
        'organizer_lastName',
        'organizer_middleName',
        'jobTitle',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'organizers_organizerID', 'organizerID');
    }
}
