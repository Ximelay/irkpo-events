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
    ];

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'faculties_facultyID', 'facultyID');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'faculties_facultyID', 'facultyID');
    }
}
