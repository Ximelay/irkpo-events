<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    public $timestamps = false;
    protected $table = 'users';
    protected $primaryKey = 'userID';

    protected $fillable = [
        'userID',
        'firstName',
        'lastName',
        'middleName',
        'email',
        'isActive',
        'createdAt',
        'roles_roleID',
        'groups_groupID',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'groups_groupID', 'groupID');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class, 'users_userID', 'userID');
    }

}
