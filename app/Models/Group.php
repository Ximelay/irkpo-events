<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    public $timestamps = false;
    protected $table = 'groups';
    protected $primaryKey = 'groupID';

    protected $fillable = [
        'groupID',
        'groupName',
        'faculties_facultyID',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculties_facultyID', 'facultyID');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'groups_groupID', 'groupID');
    }
}
