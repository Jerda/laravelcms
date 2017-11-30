<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $title = '后台管理系统';
    
    protected $callback_msg;

    protected $searchWhere = [];

    protected $searchDateWhere = [];

    protected function formatSearchWhere($data)
    {
            foreach ($data as $value) {

                foreach ($value as $key => $val) {
                    $type = $this->getWhereType($key);

                    if ($type == 'like') {
                        $this->searchWhere[] = [$key, 'like', '%' . $val . '%'];
                    } elseif ($type == 'time') {
                        $this->formatSearchDateWhere($value);
                    }
                }
            }
    }


    protected function formatSearchDateWhere($data, $field = 'created_at')
    {
        if (isset($data['start_time'])) {
            $this->searchDateWhere[] = [$field, '>=', $data['start_time']];
        } elseif (isset($data['end_time'])) {
            $end_time = Carbon::createFromFormat('Y-m-d', $data['end_time'])->modify('+1 days')->toDateString();

            $this->searchDateWhere[] = [$field, '<=', $end_time];
        }
    }


    private function getWhereType($name)
    {
        if ($name == 'start_time' || $name == 'end_time') {
            return 'time';
        } elseif ($name == 'nickname') {
            return 'like';
        }
    }


}
