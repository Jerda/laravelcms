<?php

namespace App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;
use App\Model\Admin\WechatAccount;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Admin\BaseController;

class ConfigController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | 微信接口配置控制器
    |--------------------------------------------------------------------------
    */


    /**
     * 显示微信配置页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.wechat.config.index');
    }


    /**
     * POST设置微信配置
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function set(Request $request)
    {
        if (!$this->validator($request->all())) {
            return $this->sendFailedSetResponse();
        }

        $this->addOrUpdate($request->all());

        return $this->sendSuccessSetResponse();
    }


    public function get()
    {
        $wechat_account = WechatAccount::first();

        return $wechat_account ? response()->json(['data' => $wechat_account->toArray()]) : null;
    }


    /**
     * 验证用户提交微信接口配置字段
     *
     * @param array $data
     * @return bool
     */
    private function validator(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required',
            'wechat_id' => 'required',
            'init_wechat_id' => 'required',
            'app_id' => 'required',
            'app_secret' => 'required',
            'api' => 'required',
            'token' => 'required',
            'encoding_aes_key' => 'required'
        ]);

        if ($validator->fails()) {  //用户提交字段验证失败
            $this->callback_msg = $validator->errors();
            return false;
        } else {
            return true;
        }
    }


    /**
     * 如果第一次设置，将添加配置数据，否则更新配置数据
     *
     * @param array $data
     */
    private function addOrUpdate(array $data)
    {
        if (empty($wechat_account = WechatAccount::first())) {
            WechatAccount::create($data);
        } else {
            WechatAccount::where('id', $wechat_account->id)->update($data);
        }
    }


    /**
     * 发送设置失败响应
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function sendFailedSetResponse()
    {
        return response()->json(['status' => 0, 'msg' => trans('system.must_complete_information')]);
    }


    /**
     * 发送设置成功响应
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function sendSuccessSetResponse()
    {
        return response()->json(['status' => 1, 'msg' => trans('system.set_success')]);
    }
}
