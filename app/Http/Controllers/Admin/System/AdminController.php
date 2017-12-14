<?php

namespace App\Http\Controllers\Admin\System;

use App\Model\Admin\Admin;
use App\Http\Controllers\Admin\BaseController;

class AdminController extends BaseController
{
    public function index()
    {
        return view('admin.system.admin.index');
    }


    public function showAdd()
    {
        return view('admin.system.admin.add');
    }


    public function getAll()
    {
        $admins = Admin::all();

        return response()->json(['data' => $admins]);
    }
}