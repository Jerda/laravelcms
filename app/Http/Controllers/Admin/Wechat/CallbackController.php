<?php

namespace App\Http\Controllers\Admin\Wechat;

use App\Traits\Upload;
use Illuminate\Http\Request;

class CallbackController extends WeChatController
{
    use Upload;

    public function index()
    {
        return view('admin.wechat.callback.index');
    }


    public function add(Request $request)
    {
        $data = $request->all();


    }


    public function uploadImg(Request $request)
    {
        return $request->file('file')->store('public/uploads');
    }
}