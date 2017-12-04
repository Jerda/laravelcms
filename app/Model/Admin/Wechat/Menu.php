<?php

namespace App\Model\Admin\Wechat;

use App\Traits\WechatMenu;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /*
    |--------------------------------------------------------------------------
    | 微信端按钮模型
    |--------------------------------------------------------------------------
    */
    use WechatMenu;

    protected $table = 'wechat_menu';

    protected $fillable = ['name', 'parent_id', 'type', 'link', 'key_word', 'sort_id', 'url'];


    /**
     * 查询一级按钮
     *
     * @param $query
     */
    public function scopeLevelOne($query)
    {
        $query->where('parent_id', 0);
    }

    public function scopeChildLastSortId($query, $parent_id)
    {
        $query->where('parent_id', $parent_id)->orderBy('sort_id', 'desc');
    }

    public function scopeLastSortId($query)
    {
        $query->where('parent_id',0)->orderBy('sort_id', 'desc');
    }


    public function key($query)
    {
        $res = $query->where('key', 'like', 'key_%')->orderBy('key', 'desc')->first();


    }
}
