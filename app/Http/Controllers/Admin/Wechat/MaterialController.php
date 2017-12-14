<?php
namespace App\Http\Controllers\Admin\Wechat;

use App\Model\Admin\Wechat\Material;
use Facades\App\Libraries\WechatTool;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class MaterialController extends WeChatController
{
    public function index()
    {
        return view('admin.wechat.material.index');
    }


    /*------------图文--------------*/
    public function showAddArticle()
    {
        return view('admin.wechat.material.article.add');
    }


    /*------------图片--------------*/

    /**
     * 显示添加图片
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAddImage()
    {
        return view('admin.wechat.material.image.add');
    }


    /**
     * 添加图片
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function AddImage(Request $request)
    {
        $data = $request->only('desc', 'path');

        $res = explode('/', $data['path']);

        $image_name = array_pop($res);

        $res = WechatTool::uploadImage(storage_path().'/app/public/'.$image_name);

        Material::create([
            'desc' => $data['desc'],
            'path' => $data['path'],
            'media_id' => $res['media_id'],
            'type' => 'image'
//            'url' => $res['url']
        ]);

        return response()->json(['msg' => trans('system.add_success')]);
    }


    /**
     * 获取所有图片
     * @return \Illuminate\Http\JsonResponse
     */
    public function getImages()
    {
        $images = Material::all();
        $images->each->imageLocalPath();
        $paginator = new LengthAwarePaginator($images, $images->count(), 1);
        return response()->json(['data' => $paginator]);
    }
}