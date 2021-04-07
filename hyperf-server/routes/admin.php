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

Router::get('/admins', 'App\Controller\Admin\Admins@index');
Router::addGroup('/admin', function(){
    Router::addGroup('/auth', function() {
        Router::addRoute(['GET', 'POST'], '/login', 'App\Controller\Admin\Login@index');
    });
});


//$router = new Router;

//// 获取路由配置表
//$list = AdminRoute::query()->get();
//// var_dump(list_to_tree($list->toArray(), 'route_id', 'parent_id'));
//
/// 不建议使用【实现动态路由配置（从数据库读取）】，一旦配置错误，会导致服务断开，就凉凉了
///**
// * 1.优先分组
// * 2.再对其内的进行父子及节点关联
// */
//foreach ($list as $value){
//    $value->route_method = strtoupper($value->route_method);
//    switch ($value->route_method){
//        case 'GET':
//            $router::get('/' . $value->route_url, $value->route_controller . '@' . $value->route_function);
//            break;
//        case 'POST':
//            $router::post('/' . $value->route_url, $value->route_controller . '@' . $value->route_function);
//            break;
//        case 'PUT':
//            $router::put('/' . $value->route_url, $value->route_controller . '@' . $value->route_function);
//            break;
//        case 'PATCH':
//            $router::patch('/' . $value->route_url, $value->route_controller . '@' . $value->route_function);
//            break;
//        case 'DELETE':
//            $router::delete('/' . $value->route_url, $value->route_controller . '@' . $value->route_function);
//            break;
//        default:
//            $router::addRoute(explode(',', $value->route_method), '/' . $value->route_url, $value->route_controller . '@' . $value->route_function);
//            break;
//    }
//}