<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Controller extends BaseController
{
    // 封装一个通用的API返回方法
    public function errorResponse($statusCode, $message = null, $code = 0)
    {
        // 封装一个错误响应
        throw new HttpException($statusCode, $message, null, [], $code);
    }
}
