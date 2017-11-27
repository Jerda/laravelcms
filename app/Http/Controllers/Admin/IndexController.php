<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends BaseController
{
    public function index()
    {
        $user = Auth::guard('admin')->user();
        /*return view('admin.index', [
            'title' => $this->title, 'username' => $user->username
        ]);*/
        return view('admin.layouts.app', [
            'title' => $this->title, 'username' => $user->username
        ]);
    }

    public function _index()
    {
        return view('admin._index');
    }

    public function __index()
    {
        return view('admin.__index');
    }
}
