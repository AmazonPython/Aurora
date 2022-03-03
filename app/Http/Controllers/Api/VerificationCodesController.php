<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Overtrue\EasySms\EasySms;
use App\Http\Requests\Api\VerificationCodeRequest;
use Illuminate\Auth\AuthenticationException;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, EasySms $easySms)
    {
        $captchaData = \Cache::get($request->captcha_key);

        if (! $captchaData) {
            abort(403, '图片验证码已失效');
        }

        if (! hash_equals($captchaData['code'], $request->captcha_code)) {
            // 验证错误就清除缓存
            \Cache::forget($request->captcha_key);

            throw new AuthenticationException('验证码错误');
        }

        $phone = $captchaData['phone'];

        if (!app()->environment('production')) {
            $code = '12345';
        } else {
            // 生成5位随机数，左侧补0
            $code = str_pad(random_int(1, 99999), 5, 0, STR_PAD_LEFT);

            try {
                $result = $easySms->send($phone, [
                    'template' => config('easysms.gateways.qcloud.templates.register'), // 在腾讯云配置的“短信正文”的模板ID
                    'data' => [$code], // data数组的内容对应于腾讯云“短信正文“里的变量
                ]);
            } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
                $message = $exception->getException('qcloud')->getMessage();
                abort(500, $message ?: '短信发送异常');
            }
        }

        // 缓存验证码 5分钟过期。
        $key = 'verificationCode_' . Str::random(15);
        $expiredAt = now()->addMinutes(5);
        \Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

        // 清除图片验证码缓存
        \Cache::forget($request->captcha_key);

        return response()->json([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201);
    }
}
