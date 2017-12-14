<?php

namespace App\Http\Controllers\Admin\User;

use App\Model\User;
use Illuminate\Http\Request;
use Facades\App\Libraries\WechatTool;
use App\Model\Admin\Wechat\UserGroup;
use App\Http\Controllers\Admin\BaseController;

class WechatUserController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | 微信会员控制器
    |--------------------------------------------------------------------------
    */


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
        $data = $request->only(['limit', 'search']);

        if (!empty($data['search'])) {
            $this->formatSearchWhere($data['search']);
        }

        $users = User::where($this->searchDateWhere)->with(['wechat' => function ($query) {
            $query->with('group');
        }])->whereHas('wechat', function ($query) {
            $query->where($this->searchWhere);
        })->paginate($data['limit']);

        return response()->json(['data' => $users]);
    }


    /**
     * 同步微信端用户到本地
     * @return \Illuminate\Http\JsonResponse
     */
    public function synchronizeUsers()
    {
        $open_ids = WechatTool::getUserList();

        foreach ($open_ids['data']['openid'] as $open_id) {

            if (empty(WechatTool::getUserIdByOpenID($open_id))) {
                WechatTool::addUser($open_id);
            }
        }

        return response()->json(['msg' => trans('system.synchronize_success')]);
    }


    public function showGroup()
    {
        return view('admin.user.wechat_user.group');
    }


    public function getGroups()
    {
        $groups = UserGroup::all();

        return response()->json(['data' => $groups]);
    }


    /**
     * 同步用户组
     * @return \Illuminate\Http\JsonResponse
     */
    public function synchronizeUserGroups()
    {
        $groups = WechatTool::getUserGroups()->groups;

        foreach ($groups as $group) {

            if (empty(UserGroup::where('name', $group['name'])->first())) {
                UserGroup::create(['group_id' => $group['id'], 'name' => $group['name'], 'count' => $group['count']]);
            }
        }

        return response()->json(['status' => 1, 'msg' => trans('system.synchronize_success')]);
    }


    /**
     * 添加用户组
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addUserGroup(Request $request)
    {
        $name = $request->input('name');

        if (!empty(UserGroup::where('name', $name)->first())) {
            return response()->json(['status' => 0, 'msg' => trans('system.name_is_exists')]);
        }

        WechatTool::addUserGroup($name);

        return response()->json(['status' => 1, 'msg' => trans('system.add_success')]);
    }


    /**
     * 修改用户组名称
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function modifyUserGroup(Request $request)
    {
        $data = $request->only(['group_id', 'name']);

        WechatTool::modifyUserGroup($data['group_id'], $data['name']);

        UserGroup::where('group_id', $data['group_id'])->update(['name' => $data['name']]);

        return response()->json(['msg' => trans('system.modify_success')]);
    }


    public function delUserGroup(Request $request)
    {
        $group_id = $request->input('group_id');

        WechatTool::delUserGroup($group_id);

        UserGroup::where('group_id', $group_id)->delete();

        return response()->json(['msg' => trans('system.del_success')]);
    }


    public function showUserDetail()
    {
        return view('admin.user.wechat_user.user_detail');
    }
}
