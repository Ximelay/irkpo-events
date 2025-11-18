<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    public $timestamps = false;
    protected $table = 'faculties';
    protected $primaryKey = 'facultyID';

    protected $fillable = [
        'facultyID',
        'facultyName',
        'facultyHead'
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'faculties_facultyID', 'facultyID');
    }

    public function specialities(): HasMany
    {
        return $this->hasMany(Specialty::class, 'faculties_facultyID', 'facultyID');
    }
}
