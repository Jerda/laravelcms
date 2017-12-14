<?php

namespace App\Traits;


use Illuminate\Http\Request;

trait Upload
{
    public function upload(Request $request, $name)
    {
        $res = $request->file($name)->store($name);
    }
}