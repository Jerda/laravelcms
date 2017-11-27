<?php

namespace App\Http\Controllers\Admin\User;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;

class WechatUserController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | 微信会员控制器
    |--------------------------------------------------------------------------
    */

    private $wechat_tool;

    public function __construct()
    {
        $this->wechat_tool = app('WechatTool');
    }

    public function index()
    {
        $users = User::paginate(1);
        return view('admin.user.wechat_user', compact('users'));
    }
}
