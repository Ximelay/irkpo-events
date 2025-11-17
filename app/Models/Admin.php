<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    public $timestamps = false;
    protected $table = 'admins';
    protected $primaryKey = 'adminID';

    protected $fillable = [
        'adminID',
        'admin_firstName',
        'admin_lastName',
        'admin_middleName',
        'admin_email',
        'admin_password',
        'admin_isActive',
    ];
}
