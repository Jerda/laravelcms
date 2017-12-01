<?php

namespace App\Model\Admin;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasRoles;

    protected $table = 'admins';

    protected $fillable = ['username', 'password'];

    public function getAdminByUsername($username)
    {

    }
}
