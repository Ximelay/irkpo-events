<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    public $timestamps = false;
    protected $table = 'groups';
    protected $primaryKey = 'groupID';

    protected $fillable = [
        'groupID',
        'groupName',
        'specialties_specialityID',
    ];

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Specialty::class, 'specialties_specialityID', 'specialityID');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'groups_groupID', 'groupID');
    }

    public function curators(): HasMany
    {
        return $this->hasMany(Curator::class, 'groups_groupID', 'groupID');
    }

    public function eventRegistrations(): HasMany
    {
        return $this->hasMany(EventGroupRegistration::class, 'groups_groupID', 'groupID');
    }
}
