<?php

namespace App\Traits;

use App\Model\Admin\Wechat\Menu;

trait WechatMenu
{
    /*
    |--------------------------------------------------------------------------
    | 微信信息注册
    |--------------------------------------------------------------------------
    */

    /**
     * 使用该trait的模型将自动触发该事件
     */
    public static function bootWechatMenu()
    {
        foreach (static::getModelEvents() as $event) {

            static::$event(function ($model) use ($event){
                switch ($event) {
                    case 'creating':
                        /**
                         * 验证按钮数量
                         */
                        $level = $model->parent_id == 0 ? 'level_one_max' : 'level_two_max';

                        $max = app('WechatTool')->getMenuRole($level);

                        $count = Menu::where('parent_id', $model->parent_id)->count();

                        if ($count >= $max) {
                            throw new \Exception(trans('system.button_has_max'));
                        }
                        /**
                         * 为'click'按钮添加key
                         */
                        if ($model->type == 'click') {
                            $res = $model->where('key', 'like', 'key_%')->first();

                            if (!empty($res)) {
                                $res = explode('_', $res['key']);
                                $_res = $res[1] + 1;

                                if ($_res / 10 < 1) {
                                    $model['key'] = 'key_0' . $_res;
                                } else {
                                    $model['key'] = 'key_' . $_res;
                                }
                            }
                        }
                        break;
                    case 'deleting' :
                        if (Menu::where('parent_id', $model->id)->first()) {
                            throw new \Exception(trans('system.please_del_child'));
                        }

                        $menus = Menu::where('parent_id', $model->parent_id)
                            ->where('sort_id', '>', $model->sort_id)
                            ->orderBy('sort_id', 'asc')
                            ->get();

                        if (!empty($menus)) {
                            foreach ($menus as $menu) {
                                Menu::where('id', $menu->id)->update(['sort_id' => $menu->sort_id - 1]);
                            }
                        }

                        break;
                }

            });
        }
    }


    /**
     * 查看使用该Trait的模型是否定义$recordEvents变量，
     * 如果没有将返回'created','deleting'
     * @return array
     */
    protected static function getModelEvents()
    {
        if (isset(static::$recordEvents)) {
            return static::$recordEvents;
        }

        return ['created', 'creating', 'deleting'];
    }




}