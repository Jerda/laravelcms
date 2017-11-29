<?php

namespace App\Http\Controllers\Admin\User;

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
//        $limit = $request->input('limit');
        $data = $request->only(['limit', 'search']);

        if (!empty($data['search'])) {
            $this->formatSearchWhere($data['search']);
//            $this->searchWhere[] = ['nickname', 'like', '%'.$data['search'][0]['nickname'].'%'];
        }

        $users = User::with('wechat')
            ->whereHas('wechat', function($query) {
                $query->where($this->searchWhere);
            })
            ->paginate($data['limit']);

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

        $this->wechat_tool->addUserGroup($name);

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

        $this->wechat_tool->modifyUserGroup($data['group_id'], $data['name']);

        return response()->json(['msg' => trans('system.modify_success')]);
    }
}
