<?php

return [
    // HTTP 请求的超时时间（秒）
    'timeout' => 10.0,

    // 默认发送配置
    'default' => [
        // 网关调用策略，默认：顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        // 默认可用的发送网关
        'gateways' => [
            'qcloud',
        ],
    ],

    // 可用的网关配置
    'gateways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
        ],
        'qcloud' => [
            'sdk_app_id' => env('QCLOUD_SMS_SDK_APP_ID'),
            'app_key' => env('QCLOUD_SMS_APP_KEY'),
            'secret_id' => 'QCLOUD_SMS_SECRT_ID',
            'secret_key' => 'QCLOUD_SMS_SECRT_KEY',
            'sign_name' => 'QCLOUD_SMS_SIGN_NAME',
            'templates' => [
                'register' => env('QCLOUD_SMS_TEMPLATE_REGISTER'),
            ]
        ],
    ],
];
