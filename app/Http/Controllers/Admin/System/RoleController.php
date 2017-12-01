<?php

namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Admin\BaseController;

class RoleController extends BaseController
{
    public function index()
    {
        return view('admin.system.role.index');
    }


    public function getRoles()
    {
        $roles = Role::all();

        return response()->json(['data' => $roles]);
    }


    public function showAdd()
    {
        return view('admin.system.role.add');
    }


    /**
     * 添加角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionAdd(Request $request)
    {
        $role_name = $request->input('name');

        Role::create(['name' => $role_name]);

        return response()->json(['msg' => trans('system.add_success')]);
    }
}