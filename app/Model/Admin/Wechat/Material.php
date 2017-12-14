<?php

namespace App\Model\Admin\Wechat;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['type', 'media_id', 'desc', 'path'];

    protected $table = 'wechat_material';

    public function imageLocalPath()
    {
        return $this->path = 'http://'.$_SERVER['SERVER_NAME'].$this->path;
    }
}
