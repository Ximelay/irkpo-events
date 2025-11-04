<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    public $timestamps = false;
    protected $table = 'roles';
    protected $primaryKey = 'roleID';

    protected $fillable = [
        'roleID',
        'roleName',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'roles_roleID', 'roleID');
    }
}
