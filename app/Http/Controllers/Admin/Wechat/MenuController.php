<?php

namespace App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;
use App\Model\Admin\Wechat\Menu;

class MenuController extends WechatController
{
    /*
    |--------------------------------------------------------------------------
    | 微信端按钮控制器
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return view('admin.wechat.menu.index');
    }

    /**
     * 获取按钮
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMenus()
    {
        $menus = $this->formatMenu();
        return response()->json(['status' => 1, 'data' => $menus]);
    }

    /**
     * 添加菜单页面
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAdd($id = '')
    {
        $menu = [];

        if (!empty($id)) {
            $menu = Menu::find($id);
        }

        $levelOnes = Menu::levelOne()->get();

        $this->menuAddable($levelOnes);

        return view('admin.wechat.menu.add', compact('levelOnes', 'menu'));
    }

    /**
     * 添加菜单
     *
     * @param Request $request
     * @param Menu $menu
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionAdd(Request $request, Menu $menu)
    {
        $data = $request->except('_token');

        $this->validate($request, [
            'parent_id' => 'required',
            'name' => 'required',
            'type' => 'required'
        ]);

        $data['sort_id'] = $this->getMenuLastSortId($data['parent_id']);

        try {
            $menu->create($data);
        } catch (\Exception $e) {
            return response()->json(['status' => 1, 'msg' => $e->getMessage()]);
        }

        return response()->json(['status' => 1, 'msg' => '菜单创建成功']);
    }


    /**
     * 修改菜单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionModify(Request $request)
    {
        $data = $request->except('_token');

        if (Menu::where('id', $data['id'])->update($data)) {
            return response()->json(['status' => 1, 'msg' => '菜单修改成功']);
        } else {
            return response()->json(['status' => 0, 'msg' => '菜单修改失败']);
        }
    }

    /**
     * 修改菜单排序
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionModifySortId(Request $request)
    {
        $data = $request->except('_token');
        $parent_id = $data['parent_id'];

        if ($data['direction'] == 'up') {
            $this->actionUp($data['sort_id'], $parent_id);
        } else {
            $this->actionDown($data['sort_id'], $parent_id);
        }

        return response()->json(['status' => 1, 'msg' => '修改成功']);
    }


    /**
     * 菜单删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionDel(Request $request)
    {
        $id = $request->input('id');

        try {
            $menu = Menu::find($id);
            $menu->delete();
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'msg' => $e->getMessage()]);
        }

        return response()->json(['status' => 1, 'msg' => '菜单删除成功']);
    }


    /**
     * 发布菜单
     */
    public function issueMenus()
    {
        $menu = $this->app->menu;

        try {
            $menu->add($this->convertMenu());
            return response()->json(['status' => 1, 'msg' => '菜单添加成功']);
        } catch (\Exception $e) {
            $message = app('WechatTool')->getMessage($e);
            return response()->json(['status' => 0, 'msg' => $message]);
        }
    }

    /**
     * 获取所有菜单并排序
     * @return mixed
     */
    private function formatMenu()
    {
        $menus = Menu::all()->toArray();
        $arr = $this->menuSort($this->treeSort($menus, true));
        return $arr;
    }

    /**
     * 将菜单转换成微信接口所需的格式
     * @return array
     */
    private function convertMenu()
    {
        $_menus = [];
        $menus = Menu::all()->toArray();
        $menus = $this->treeSort($menus);

        foreach ($menus as $menu) {
            $_menus[$menu['id']] = $menu;

            if (isset($menu['children'])) {

                foreach ($menu['children'] as $child) {
                    $_menus[$child['parent_id']]['sub_button'][] = $child;
                }

                unset($_menus[$menu['id']]['children']);
            }

            /*if ($menu['parent_id'] == 0) {
                $_menus[$menu['id']] = $menu;
            } else {
                $_menus[$menu['parent_id']]['sub_button'][] = $menu;
            }*/

        }

        $new = [];

        foreach ($_menus as $menu) {

            if (isset($menu['sub_button'])) {

                foreach ($menu['sub_button'] as $sub) {
                    $add = [
                        'type' => $sub['type'],
                        'name' => $sub['name'],
                    ];

                    if ($add['type'] == 'click') {
                        $add['key'] = $sub['key'];
                    } elseif ($add['type'] == 'view') {
                        $add['url'] = $sub['url'];
                    } else {
                        $add['key'] = $sub['key_word'];
                    }

                    $new[] = [
                        'name' => $menu['name'],
                        'sub_button' => [$add]
                    ];
                }
            } else {
                $add = [
                    'type' => $menu['type'],
                    'name' => $menu['name'],
                ];

                if ($add['type'] == 'click') {
                    $add['key'] = $menu['key_word'];
                } elseif ($add['type'] == 'view') {
                    $add['url'] = $menu['url'];
                } else {
                    $add['key'] = $menu['key_word'];
                }

                $new[] = $add;
            }
        }

        return $new;
    }

    /**
     * 将子菜单装入父菜单中
     *
     * @param $data array
     * @param bool $isShow
     * @param $parent_id  integer   父权限ID，该参数一般不填，主要在递归时用。
     * @param int $sort_id
     * @return array
     */
    private function treeSort($data, $isShow = false, $parent_id = 0, $sort_id = 0)
    {
        static $arr = [];

        foreach ($data as $value) {

            if ($value['parent_id'] == $parent_id) {

                if ($isShow && $value['parent_id'] != 0) {
                    $value['name'] = '&nbsp;&nbsp;&nbsp;&nbsp;|-----' . $value['name'];
                }

                if ($parent_id == 0) {
                    $arr[$value['sort_id']] = $value;
                } else {
                    $arr[$sort_id]['children'][$value['sort_id']] = $value;
                }

                $this->treeSort($data, $isShow, $value['id'], $value['sort_id']);
            }
        }

        return $arr;
    }

    /**
     * 判断二级菜单数量是否允许添加
     * @param $levelOnes
     */
    private function menuAddable(&$levelOnes)
    {
        foreach ($levelOnes as &$levelOne) {
            $levelTwo = Menu::where('parent_id', $levelOne->id)->select();

//            if ($levelTwo->count() >= $this->menu_role['level_two_max']) {
            if ($levelTwo->count() >= app('WechatTool')->getMenuRole('level_two_max')) {
                $levelOne['addable'] = false;
            } else {
                $levelOne['addable'] = true;
            }
        }
    }

    /**
     * 获取菜单最后一个排序号
     * @param $parent_id
     * @return mixed
     */
    private function getMenuLastSortId($parent_id)
    {
        if ($parent_id != 0) {
            $menu = Menu::childLastSortId($parent_id)->first();

            if (empty($menu)) {
                return 0;
            }

            return $menu->sort_id + 1;
        } else {
            $menu = Menu::lastSortId()->first();

            if (empty($menu)) {
                return 0;
            }

            return $menu->sort_id + 1;
        }
    }

    /**
     * 菜单向上移动
     * @param $sort_id
     * @param $parent_id
     */
    private function actionUp($sort_id, $parent_id)
    {
        $up_menu = $this->getRelateMenu($sort_id, $parent_id);
        $current_menu = Menu::where('sort_id', $sort_id)->where('parent_id', $parent_id)->first();
        $current_menu->sort_id = intval($up_menu->sort_id);
        $up_menu->sort_id = $sort_id;
        $up_menu->save();
        $current_menu->save();
    }

    /**
     * 菜单向下移动
     * @param $sort_id
     * @param $parent_id
     */
    private function actionDown($sort_id, $parent_id)
    {
        $down_menu = $this->getRelateMenu($sort_id, $parent_id, 'down');
        $current_menu = Menu::where('sort_id', $sort_id)->where('parent_id', $parent_id)->firstOrFail();
        $current_menu->sort_id = $down_menu['sort_id'];
        $down_menu->sort_id = $sort_id;
        $down_menu->save();
        $current_menu->save();
    }

    /**
     * 菜单排序
     * @param $arr
     * @return mixed
     */
    private function menuSort($arr)
    {
        ksort($arr);

        foreach ($arr as &$value) {
            if (isset($value['children'])) {
                ksort($value['children']);
            }
        }

        return $arr;
    }

    /**
     * 获取菜单关联的上一个菜单或下一个菜单,该方法用户菜单排序
     * @param $sort_id
     * @param $parent_id
     * @param string $direction
     * @param int $step
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    private function getRelateMenu($sort_id, $parent_id, $direction = 'up', $step = 1)
    {
        if ($direction == 'down') {
            $up_menu = Menu::where('sort_id', $sort_id + $step)->where('parent_id', $parent_id)->first();
        } else {
            $up_menu = Menu::where('sort_id', $sort_id - $step)->where('parent_id', $parent_id)->first();
        }

        if (empty($up_menu)) {
            return $this->getRelateMenu($sort_id, $parent_id, $direction, $step + 1);
        } else {
            return $up_menu;
        }
    }

    public function test()
    {
        $arr = [
            "name" => "菜单1",
            "sub_button" => ["type" => "view", "name" => "子菜单1", "url" => "www.sina.com"],
        ];
        $arr1 = [
            "name" => "菜单2",
            "sub_button" => [
                "type" => "click", "name" => "子菜单1", "key" => "key"
            ]
        ];
    }
}
