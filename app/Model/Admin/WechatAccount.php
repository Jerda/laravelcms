<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class WechatAccount extends Model
{
    /*
    |--------------------------------------------------------------------------
    | 微信账号模型
    |--------------------------------------------------------------------------
    */

    protected $table = 'wechat_account';

    protected $fillable = [
        'name', 'wechat_id', 'init_wechat_id', 'app_id', 'app_secret', 'api',
        'token', 'encoding_aes_key', 'auth_file', 'qr_code', 'attention'
    ];
}
