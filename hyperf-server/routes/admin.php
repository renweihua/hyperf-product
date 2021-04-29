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

//
//Router::get('/admins', 'App\Controller\Admin\Admins@index');
//Router::addGroup('/admin', function(){
//    Router::addGroup('/auth', function() {
//        Router::addRoute(['GET', 'POST'], '/login', 'App\Controller\Admin\Login@index');
//    });
//});

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

// put不限制必须id，格式影响前端传参限制，不便于书写

use App\Controller\Admin\Login;

Router::addGroup(
    '/admin',
    function() {
        // 登录
        Router::post('/auth/login', [Login::class, 'login']);

        Router::addGroup('', function() {
            // 登录相关的API
            Router::addGroup('/auth', function() {
                Router::post('/me', [Login::class, 'me']);
                Router::post('/userInfo', [Login::class, 'userInfo']);
                Router::post('/getRabcList', [Login::class, 'getRabcList']);
                Router::post('/logout', [Login::class, 'logout']);
            });
            // 首页统计
            Router::get('/indexs', [\App\Controller\Admin\Index::class, 'index']);
            // 按照日志类型的统计图数据
            Router::get('/logsStatistics', [\App\Controller\Admin\Index::class, 'logsStatistics']);
            // 版本的历史记录
            Router::get('/versionLogs', [\App\Controller\Admin\Index::class, 'versionLogs']);
            // 获取服务器状态
            Router::get('/getServerStatus', [\App\Controller\Admin\Index::class, 'getServerStatus']);

            // 月份表列表
            Router::get('/get_month_lists', [\App\Controller\Admin\Index::class, 'getMonthList']);

            // 文件上传
            Router::post('/upload_file', [\App\Controller\Admin\UploadFiles::class, 'file']);
            Router::post('/upload_files', [\App\Controller\Admin\UploadFiles::class, 'files']);

            Router::addGroup('', function() {
                // 文件管理
                Router::get('/files', [\App\Controller\Admin\UploadFiles::class, 'index']);
                Router::delete('/files/delete', [\App\Controller\Admin\UploadFiles::class, 'delete']);

                // 管理员
                Router::get('/admins', [\App\Controller\Admin\Admins::class, 'index']);
                Router::get('/admins/detail/{id}', [\App\Controller\Admin\Admins::class, 'detail']);
                Router::post('/admins/create', [\App\Controller\Admin\Admins::class, 'create']);
                //Router::put('/admins/{id}', [\App\Controller\Admin\Admins::class, 'update']);
                Router::put('/admins/update', [\App\Controller\Admin\Admins::class, 'update']);
                Router::delete('/admins/delete', [\App\Controller\Admin\Admins::class, 'delete']);
                Router::get('/admins/getSelectLists', [\App\Controller\Admin\Admins::class, 'getSelectLists']);
                Router::put('/admins/changeFiledStatus', [\App\Controller\Admin\Admins::class, 'changeFiledStatus']);

                // 角色
                Router::get('/admin_roles', [\App\Controller\Admin\AdminRoles::class, 'index']);
                Router::get('/admin_roles/detail/{id}', [\App\Controller\Admin\AdminRoles::class, 'detail']);
                Router::post('/admin_roles/create', [\App\Controller\Admin\AdminRoles::class, 'create']);
                Router::put('/admin_roles/update', [\App\Controller\Admin\AdminRoles::class, 'update']);
                Router::delete('/admin_roles/delete', [\App\Controller\Admin\AdminRoles::class, 'delete']);
                Router::get('/admin_roles/getSelectLists', [\App\Controller\Admin\AdminRoles::class, 'getSelectLists']);
                Router::put('/admin_roles/changeFiledStatus', [\App\Controller\Admin\AdminRoles::class, 'changeFiledStatus']);

                // 菜单
                Router::get('/admin_menus', [\App\Controller\Admin\AdminMenus::class, 'index']);
                Router::get('/admin_menus/detail/{id}', [\App\Controller\Admin\AdminMenus::class, 'detail']);
                Router::post('/admin_menus/create', [\App\Controller\Admin\AdminMenus::class, 'create']);
                Router::put('/admin_menus/update', [\App\Controller\Admin\AdminMenus::class, 'update']);
                Router::delete('/admin_menus/delete', [\App\Controller\Admin\AdminMenus::class, 'delete']);
                Router::get('/admin_menus/getSelectLists', [\App\Controller\Admin\AdminMenus::class, 'getSelectLists']);
                Router::put('/admin_menus/changeFiledStatus', [\App\Controller\Admin\AdminMenus::class, 'changeFiledStatus']);

                // 管理员日志
                Router::get('/admin_logs', [\App\Controller\Admin\AdminLogs::class, 'index']);
                Router::delete('/admin_logs/delete', [\App\Controller\Admin\AdminLogs::class, 'delete']);

                // 管理员登录日志
                Router::get('/admin_login_logs', [\App\Controller\Admin\AdminLoginLogs::class, 'index']);
                Router::delete('/admin_login_logs/delete', [\App\Controller\Admin\AdminLoginLogs::class, 'delete']);

                // 友情链接
                Router::get('/friendlinks', [\App\Controller\Admin\FriendLinks::class, 'index']);
                Router::get('/friendlinks/detail/{id}', [\App\Controller\Admin\FriendLinks::class, 'detail']);
                Router::post('/friendlinks/create', [\App\Controller\Admin\FriendLinks::class, 'create']);
                Router::put('/friendlinks/update', [\App\Controller\Admin\FriendLinks::class, 'update']);
                Router::delete('/friendlinks/delete', [\App\Controller\Admin\FriendLinks::class, 'delete']);
                Router::put('/friendlinks/changeFiledStatus', [\App\Controller\Admin\FriendLinks::class, 'changeFiledStatus']);

                // banner
                Router::get('/banners', [\App\Controller\Admin\Banners::class, 'index']);
                Router::get('/banners/detail/{id}', [\App\Controller\Admin\Banners::class, 'detail']);
                Router::post('/banners/create', [\App\Controller\Admin\Banners::class, 'create']);
                Router::put('/banners/update', [\App\Controller\Admin\Banners::class, 'update']);
                Router::delete('/banners/delete', [\App\Controller\Admin\Banners::class, 'delete']);
                Router::put('/banners/changeFiledStatus', [\App\Controller\Admin\Banners::class, 'changeFiledStatus']);

                // 配置管理
                Router::get('/configs', [\App\Controller\Admin\Configs::class, 'index']);
                Router::get('/configs/detail/{id}', [\App\Controller\Admin\Configs::class, 'detail']);
                Router::post('/configs/create', [\App\Controller\Admin\Configs::class, 'create']);
                Router::put('/configs/update', [\App\Controller\Admin\Configs::class, 'update']);
                Router::delete('/configs/delete', [\App\Controller\Admin\Configs::class, 'delete']);
                Router::put('/configs/changeFiledStatus', [\App\Controller\Admin\Configs::class, 'changeFiledStatus']);
                Router::post('/configs/pushRefreshConfig', [\App\Controller\Admin\Configs::class, 'pushRefreshConfig']);
            }, [
                // 权限验证
                'middleware' => [
                    // \App\Middleware\Admin\RabcMiddleware::class
                ],
            ]);
        }, [
            // JWT认证
            'middleware' => [
                \App\Middleware\Admin\TokenAuthMiddleware::class
            ],
        ]);
    },
    [
        'middleware' => [
             App\Middleware\CorsMiddleware::class,
        ],
    ]
);
