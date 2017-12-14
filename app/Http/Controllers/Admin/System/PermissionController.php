<?php

namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Admin\BaseController;

class PermissionController extends BaseController
{
    public function index()
    {
        return view('admin.system.permission.index');
    }


    public function getPermissions()
    {
        $permissions = Permission::all()->toArray();

        $permissions = $this->treeSort($permissions);

        return response()->json(['data' => $permissions]);
    }


    public function showAdd()
    {
        return view('admin.system.permission.add');
    }


    /**
     * 添加权限
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionAdd(Request $request)
    {
        $data = $request->all();

        Permission::create([
            'name' => $data['name'],
            'parent_id' => $data['parent_id'],
            'level' => $this->getLevel(new Permission(), $data['parent_id'])]);

        return response()->json(['msg' => trans('system.add_success')]);
    }


    /**
     * 删除权限
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function del(Request $request)
    {
        $id = $request->input('id');

        if (Permission::where('parent_id', $id)->first()) {
            return response()->json(['status' => 0, 'msg' => trans('system.please_del_child')]);
        }

        Permission::destroy($id);

        return response()->json(['status' => 1, 'msg' => trans('system.del_success')]);
    }


    public function getPermissionsByTree()
    {
        $permissions = Permission::all()->toArray();

        $arr = [];

        foreach ($permissions as $permission) {
            if ($permission['parent_id'] == 0) {
                $arr[$permission['id']] = ['name' => $permission['name'], 'children' => []];
            } else {
                $arr[$permission['parent_id']]['children'][] = ['name' => $permission['name']];
            }
        }

        return response()->json(['data' => $arr]);
    }


    /**
     * 通过parent_id获取权限
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /*public function getPermissionByParentId(Request $request)
    {
        $parent_id = $request->input('parent_id');

        $permissions = Permission::where('parent_id', $parent_id)->get()->toArray();

        return response()->json(['data' => $permissions]);
    }*/
}