<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $title = '后台管理系统';
    
    protected $callback_msg;

    protected $searchWhere = [];

    protected $searchDateWhere = [];


    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $config = config('system');

        $this->title = $config['admin_system_name'];
    }


    /**
     * todo 此方法在了解更多EloQuent后进行重构
     * @param $data
     */
    protected function formatSearchWhere($data)
    {
            foreach ($data as $value) {

                foreach ($value as $key => $val) {
                    $type = $this->getWhereType($key);

                    if ($type == 'like') {
                        $this->searchWhere[] = [$key, 'like', '%' . $val . '%'];
                    } elseif ($type == 'time') {
                        $this->dateWhere($value);
                    }
                }
            }
    }


    protected function dateWhere($data, $field = 'created_at')
    {
        if (isset($data['start_time'])) {
            $this->searchDateWhere[] = [$field, '>=', $data['start_time']];
        } elseif (isset($data['end_time'])) {
            $end_time = Carbon::createFromFormat('Y-m-d', $data['end_time'])->modify('+1 days')->toDateString();

            $this->searchDateWhere[] = [$field, '<=', $end_time];
        }
    }


    protected function getWhereType($name)
    {
        if ($name == 'start_time' || $name == 'end_time') {
            return 'time';
        } elseif ($name == 'nickname') {
            return 'like';
        }
    }


    /**
     * 获取级别
     * @param $model
     * @param $parent_id
     * @return int
     */
    protected function getLevel(Model $model, $parent_id)
    {
        $level = 0;

        if ($parent_id != 0) {
            $parent = $model::find($parent_id);

            $level = $parent->level + 1;
        }

        return $level;
    }


    /**
     * 权限无限级排序
     * 将子权限分装在对应的父权限数组中
     *
     * @param $data array     权限数据
     * @param $pid  integer   父权限ID，该参数一般不填，主要在递归时用。
     * @return array
     */
    protected function treeSort($data, $pid = 0)
    {
        static $arr = [];

        foreach ($data as $value) {

            if ($pid != 0) {

                $value['name'] = $this->treeSign($value['level']) . $value['name'];
            }

            if ($value['parent_id'] == $pid) {
                $arr[] = $value;

                $this->treeSort($data, $value['id']);
            }
        }

        return $arr;
    }


    /**
     * 添加权限等级展示前的标识符
     * 通过$level*$num值来确定前面添加多少‘空格’
     * 演示: |-----xxxxx (level == 0  不添加)
     *              |------yyyyyy （level == 1 添加1*6个空格）
     *
     * @param $level integer 等级
     * @param $num   integer 标识符前面空格倍数，默认为6可以获得较好的效果
     * @return string
     */
    protected function treeSign($level, $num = 6)
    {
        $str = '';

        if ($level != 0) {
            $str = str_repeat('&nbsp;', $level * $num);
        } else {
            return '';
        }

        if ($level > 1) {
            $str .= str_repeat('&nbsp;', $num);
        }

        return $str.'|----';
    }


    /**
     * 上传图片
     * @param Request $request
     * @return false|string
     */
    public function uploadImage(Request $request)
    {
        $path = $request->file('file')->store('public');

        $res = explode('/', $path);

        $image_name = array_pop($res);

        $path = [
            'url' => $request->root().'/storage/'.$image_name,
            'local' => '/storage/'.$image_name
        ];

        return response()->json(['data' => $path]);
    }
}
