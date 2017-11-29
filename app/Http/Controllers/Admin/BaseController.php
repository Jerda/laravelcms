<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $title = '后台管理系统';
    
    protected $callback_msg;

    protected $searchWhere = [];

    protected function formatSearchWhere($data)
    {
//        $search = $request->input('search');
            foreach ($data as $value) {

//            $type = $this->getWhereType($key);
                foreach ($value as $key => $val) {
                    $this->searchWhere[] = [$key, 'like', '%' . $val . '%'];
                }
            }

    }
}
