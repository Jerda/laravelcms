<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Model\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';


    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * 显示注册页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('admin.auth.register', ['title' => $this->title]);
    }


    /**
     * 注册管理员用户
     *
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request)
    {

        if (!$this->validator($request->all())) {
            return $this->unregistered();
        }

        $user = $this->create($request->all());

        $this->guard()->login($user);

        return $this->registered($request);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return bool|\Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'captcha'  => 'required|captcha'
        ]);

        if ($validator->fails()) {  //用户提交字段验证失败
            $this->callback_msg = $validator->errors();
            return false;
        } else {
                                    //判断用户名是否已存在
            if (Admin::where('username', $data['username'])->first()) {
                $this->callback_msg = [trans('system.system_error')];
                return false;
            }

        }

        return true;
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return Admin::create([
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);
    }


    /**
     * 注册成功,返回信息
     *
     * @return mixed
     */
    protected function registered()
    {
        return response()->json(['status' => 1, 'msg' => trans('system.register_success')]);
    }


    /**
     * 注册失败,返回信息
     *
     * @return mixed
     */
    protected function unregistered()
    {
        return response()->json(['status' => 0, 'msg' => $this->callback_msg]);
    }
}
