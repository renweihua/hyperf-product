<?php

declare(strict_types = 1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

// 获取访问API的token
Router::get('/get_api_token', 'App\Controller\IndexController@getApiToken');

Router::addGroup('',
    function() {
        Router::get('/api', 'App\Controller\Api\Index@api');
    },
    [
        'middleware' => [
            // 跨域中间件
            App\Middleware\CorsMiddleware::class,
            // API访问的Token验证中间件
            \App\Middleware\Api\VisitApiTokenMiddleware::class,
            // API接口规范的中间件
            \App\Middleware\Api\ApiFormatSpecificationMiddleware::class,
        ],
    ]
);
