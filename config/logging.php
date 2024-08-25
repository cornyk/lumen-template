<?php

use App\Utils\LogFormatterUtil;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the log channel that should be used to log warnings
    | regarding deprecated PHP and library features. This allows you to get
    | your application ready for upcoming major versions of dependencies.
    |
    */

    'deprecations' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        // 默认日志
        'stack' => [
            'driver' => 'stack',
            'channels' => ['app', 'error'],
        ],
        // 业务日志
        'app' => [
            'driver' => 'daily',
            'path' => storage_path('logs/app.log'),
            'level' => 'debug',
            'days' => 30,
            'formatter' => LogFormatterUtil::class,
            'permission' => 0777,
        ],
        // 错误日志
        'error' => [
            'driver' => 'daily',
            'path' => storage_path('logs/error.log'),
            'level' => 'error',
            'days' => 30,
            'formatter' => LogFormatterUtil::class,
            'permission' => 0777,
        ],
        // 请求日志
        'access' => [
            'driver' => 'daily',
            'path' => storage_path('logs/access.log'),
            'level' => 'debug',
            'days' => 30,
            'formatter' => LogFormatterUtil::class,
            'permission' => 0777,
        ],
        // SQL日志
        'sql' => [
            'driver' => 'daily',
            'path' => storage_path('logs/sql.log'),
            'level' => 'debug',
            'days' => 30,
            'formatter' => LogFormatterUtil::class,
            'permission' => 0777,
        ],
        // SQL错误日志
        'sql_error' => [
            'driver' => 'daily',
            'path' => storage_path('logs/sqlerr.log'),
            'level' => 'debug',
            'days' => 30,
            'formatter' => LogFormatterUtil::class,
            'permission' => 0777,
        ],
        // 慢SQL日志
        'slow_sql' => [
            'driver' => 'daily',
            'path' => storage_path('logs/slowsql.log'),
            'level' => 'debug',
            'days' => 30,
            'formatter' => LogFormatterUtil::class,
            'permission' => 0777,
        ],
        // 发送请求日志
        'send_request' => [
            'driver' => 'daily',
            'path' => storage_path('logs/reqsend.log'),
            'level' => 'debug',
            'days' => 30,
            'formatter' => LogFormatterUtil::class,
            'permission' => 0777,
        ],
        // 发送请求错误日志
        'send_request_error' => [
            'driver' => 'daily',
            'path' => storage_path('logs/reqsenderr.log'),
            'level' => 'debug',
            'days' => 30,
            'formatter' => LogFormatterUtil::class,
            'permission' => 0777,
        ],
    ],
];
