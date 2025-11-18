<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Specialty extends Model
{
    public $timestamps = false;
    protected $table = 'specialties';
    protected $primaryKey = 'specialityID';

    protected $fillable = [
        'specialityID',
        'specialityName',
        'specialityCode',
        'faculties_facultyID',
    ];

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'faculties_facultyID', 'facultyID');
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'specialties_specialityID', 'specialityID');
    }
}
