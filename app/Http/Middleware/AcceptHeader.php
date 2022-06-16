<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AcceptHeader
{
    /**
     * 为接口设置 Accept 请求头，将其转化为 application/json 格式
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
