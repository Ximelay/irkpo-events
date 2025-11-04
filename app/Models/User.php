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
        'password',
        'isActive',
        'createdAt',
        'roles_roleID',
        'groups_groupID',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'roles_roleID', 'roleID');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'groups_groupID', 'groupID');
    }

    public function organizedEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'users_OrganizerID', 'userID');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class, 'users_userID', 'userID');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(EventExpense::class, 'users_purchasedBy', 'userID');
    }
}
