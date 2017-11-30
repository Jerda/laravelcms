<?php

namespace App\Model\Admin\Wechat;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $table = 'wechat_user_group';

    protected $fillable = ['group_id', 'name', 'count'];

    public $timestamps = false;

}
