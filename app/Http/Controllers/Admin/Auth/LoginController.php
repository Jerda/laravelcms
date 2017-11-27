<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/index';

    protected $title = '后台登录';

    private $guard = 'admin';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
//        $this->middleware('guest');
    }


    /**
     * 显示登录页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.auth.login', ['title' => $this->title]);
    }


    public function login(Request $request)
    {
        if (!$this->validateLogin($request->all())) {
            return response()->json(['status' => 0, 'msg' => $this->callback_msg]);
        };

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    protected function guard()
    {
        return Auth::guard($this->guard);
    }


    public function username()
    {
        return 'username';
    }


    protected function validateLogin($data)
    {
        $validator = Validator::make($data, [
            'username' => 'required|string|max:255|min:5',
            'password' => 'required|string|min:6',
            'captcha'  => 'required|captcha'
        ]);

        if ($validator->fails()) {
            $this->callback_msg = $validator->errors();
            return false;
        } else {
            return true;
        }
    }


    protected function sendFailedLoginResponse()
    {
        return response()->json(['status' => 0, 'msg' => [$this->username() => [trans('auth.failed')]]]);
    }


    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        return response()->json(['status' => 0, 'msg' => [$this->username() => [Lang::get('auth.throttle', ['seconds' => $seconds])]]]);
    }


    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $this->guard()->user();

        return response()->json(['status' => 1, 'msg' => trans('system.login_success')]);
    }
}
