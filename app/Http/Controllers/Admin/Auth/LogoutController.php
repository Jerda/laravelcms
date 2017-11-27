<?php
namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BaseController;

class LogoutController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | 登出控制器
    |--------------------------------------------------------------------------
    |
    | 由于数据库中被没有remember_token字段，这里登，
    | 出会有SQL错误所以暂时捕获并无视错误
    |
    */

    public function logout()
    {
        try {
            Auth::guard('admin')->logout();
        } catch (\Exception $e) {
            return redirect('admin/login');
        }
    }
}