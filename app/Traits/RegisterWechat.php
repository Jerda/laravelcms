<?php

namespace App\Traits;

trait RegisterWechat
{
    /*
    |--------------------------------------------------------------------------
    | 微信信息注册
    |--------------------------------------------------------------------------
    |
    | 当模型使用该Trait时，模型发生事件会自动触发bootRegisterWechat()方法，
    | 并执行相应的操作.
    | 使用方法：模型必须定义一个静态变量$wechat_data，并为它生成
    | getWechatData()和setWechatData(),该变量主要用于保存
    | 从微信端获得用户微信数据，然后通过该变量数据
    | 存储于数据库中
    |
    */

    /**
     * 使用该trait的模型将自动触发该事件
     */
    public static function bootRegisterWechat()
    {
        foreach (static::getModelEvents() as $event) {
            static::$event(function ($model) use ($event){

                switch ($event) {
                    case 'created' :
                        $model->registerWechat();
                        break;
                    case 'deleting' :
                        $model->unRegisterWechat();
                        break;
                }

            });
        }
    }


    /**
     * 创建用户微信信息
     */
    protected function registerWechat()
    {
        $this->setWechatData(array_merge($this->getWechatData(), ['user_id' => $this->id]));

        $this->wechat()->create($this->getWechatData());
    }


    /**
     * 删除用户微信信息
     */
    protected function unRegisterWechat()
    {
        $this->wechat()->delete();
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

        return ['created', 'deleting'];
    }

}