<?php

declare(strict_types = 1);

namespace App\Middleware\Admin;

use App\Constants\StatusConst;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Model\Rabc\AdminMenu;
use App\Model\Rabc\RoleWithMenu;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Di\Annotation\Inject;

class RabcMiddleware implements MiddlewareInterface
{
    protected $response;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $requestInterface;

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container, HttpResponse $response)
    {
        $this->container = $container;
        $this->response = $response;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        // 请求方式
        $method = $this->requestInterface->getMethod();
        // 获取当前路由
        $route_path = trim($this->requestInterface->getPathInfo(), '/');
        // 开始验证路由权限
        if (!$this->checkRabc($request->admin['admin_id'], $request->admin['roles'], $route_path)){
            return $this->response->json(['message' => '无权限', 'status' => StatusConst::UN_RABC, 'data' => []]);
        }
        return $handler->handle($request);
    }

    private function checkRabc(int $admin_id, array $roles = [], string $route_path):bool
    {
        if (!empty($roles)){
            $role_ids = array_column((array)$roles, 'role_id');
            $menu_ids = RoleWithMenu::getInstance()->getMenuIdsByRoles($role_ids);
            $menus = AdminMenu::getMenusByIds($menu_ids);
            $menus = array_column($menus, 'api_url', 'api_url');
            // foreach ($roles as $role){
            //     $menus[] = array_column($role->menus, 'api_url', 'api_url');
            // }
            if (empty($menus)) return false;
            if (array_key_exists($route_path, $menus)) return true;
        }
        return false;
    }
}