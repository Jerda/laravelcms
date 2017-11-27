<?php

namespace App\Model;

//use Illuminate\Database\Eloquent\Model;
use App\Traits\RegisterWechat;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    use RegisterWechat;

    protected $table = 'users';

    public static $wechat_data = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'username', 'email', 'password', 'mobile', 'name', 'user_num', 'type',
        'idcard_num', 'idcard_img', 'QQ', 'remark',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /*protected $hidden = [
        'password', 'remember_token',
    ];*/

    public function wechat()
    {
        return $this->hasOne('App\Model\UserWechat');
    }

    public static function setWechatData($data)
    {
        static::$wechat_data = $data;
    }

    public static function getWechatData()
    {
        return static::$wechat_data;
    }
}
