<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
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

    // Скрытие пароля при сериализации
    protected $hidden = [
        'admin_password',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->admin_password;
    }

    public function getEmailForPasswordReset()
    {
        return $this->admin_email;
    }
}
