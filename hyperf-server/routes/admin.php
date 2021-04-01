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
use App\Model\Rabc\AdminRoute;

$router = new Router;

// 获取路由配置表
$list = AdminRoute::query()->get();
var_dump($list->toArray());

foreach ($list as $value){
    $value->route_method = strtoupper($value->route_method);
    switch ($value->route_method){
        case 'GET':
            $router::get('/' . $value->route_url, $value->route_controller . '@' . $value->route_function);
            break;
        case 'POST':
            $router::post('/' . $value->route_url, $value->route_controller . '@' . $value->route_function);
            break;
        case 'PUT':
            $router::put('/' . $value->route_url, $value->route_controller . '@' . $value->route_function);
            break;
        case 'PATCH':
            $router::patch('/' . $value->route_url, $value->route_controller . '@' . $value->route_function);
            break;
        case 'DELETE':
            $router::delete('/' . $value->route_url, $value->route_controller . '@' . $value->route_function);
            break;
        default:
            $router::addRoute(explode(',', $value->route_method), '/' . $value->route_url, $value->route_controller . '@' . $value->route_function);
            break;
    }
}