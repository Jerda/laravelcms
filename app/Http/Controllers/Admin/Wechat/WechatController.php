<?php

namespace App\Http\Controllers\Admin\Wechat;

use App\Http\Controllers\Controller;

class WeChatController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 微信接口配置控制器
    |--------------------------------------------------------------------------
    | 微信主控制器，微信端验证配置及服务都在此控制器中
    |
    */


    public function actionServer()
    {
        return app('WechatTool')->server();
    }
}