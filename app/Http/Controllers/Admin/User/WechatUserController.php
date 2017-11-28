<?php

namespace App\Http\Controllers\Admin\User;

use App\Model\Admin\Wechat\UserGroup;
use App\Model\User;
use Illuminate\Http\Request;
use App\Model\Admin\Wechat\UserGroup;
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
        return view('admin.user.wechat_user.index');
    }

    /**
     * 获取微信用户数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsers(Request $request)
    {
        $limit = $request->input('limit');

        $users = User::with('wechat')->paginate($limit);

        return response()->json(['data' => $users]);
    }


    /**
     * 同步微信端用户到本地
     * @return \Illuminate\Http\JsonResponse
     */
    public function synchronizeUsers()
    {
        $open_ids = $this->wechat_tool->getUserList();

        foreach ($open_ids->data['openid'] as $open_id) {

            if (empty($this->wechat_tool->getUserIdByOpenID($open_id))) {
                $this->wechat_tool->addUser($open_id);
            }
        }

        return response()->json(['msg' => trans('system.synchronize_success')]);
    }


    public function showGroup()
    {
        return view('admin.user.wechat_user.group');
    }


    /**
     * 同步用户组
     * @return \Illuminate\Http\JsonResponse
     */
    public function synchronizeUserGroups()
    {
        $groups = $this->wechat_tool->getUserGroups()->groups;

        foreach ($groups as $group) {

            if (empty(UserGroup::where('name', $group['name'])->first())) {
                UserGroup::create(['group_id' => $group['id'], 'name' => $group['name'], 'count' => $group['count']]);
            }
        }

        return response()->json(['msg' => trans('system.synchronize_success')]);
    }
}
