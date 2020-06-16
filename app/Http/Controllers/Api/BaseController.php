<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    //
    //
    /**
     * Json格式返回
     */
    public function response($status = 200, $message = '', $data = null){
        $timestamp = time();
//        if (!config('app.api_debug') && $status == 500) $message = '服务器或数据提交异常，请稍后重试';
//        return compact('status', 'message', 'data', 'timestamp');

        return [
            'stauts' => $status,
            'message' => $message,
            'data' => $data,
            'timestamp' => $timestamp
        ];
    }
}
