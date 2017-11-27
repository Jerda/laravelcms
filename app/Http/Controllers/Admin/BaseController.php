<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $title = '后台管理系统';
    
    protected $callback_msg;
}
