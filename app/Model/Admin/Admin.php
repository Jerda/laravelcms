<?php

namespace App\Model\Admin;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';

    protected $fillable = ['username', 'password'];

    public function getAdminByUsername($username)
    {

    }
}
