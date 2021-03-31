<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Event\Admin\AdminLoginEvent;
use App\Request\Admin\LoginRequest;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\Di\Annotation\Inject;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Login
 *
 * @Controller()
 *
 * @package App\Controller\Admin
 */
class Login extends AbstractController
{
    /**
     * @Inject
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @RequestMapping(path="/admin/auth/login", methods="get, post")
     */
    public function index(LoginRequest $request): ResponseInterface
    {
        // 获取通过验证的数据...
        $validated = $request->validated();
        var_dump($validated);

        $admin = [
            'admin_id' => 1,
            'admin_name' => 'cnpscy',
        ];

        // 事件需要通过 事件调度器(EventDispatcher) 调度才能让 监听器(Listener) 监听到
        // 这里 dispatch(object $event) 会逐个运行监听该事件的监听器
        $this->eventDispatcher->dispatch(new AdminLoginEvent($admin));

        return $this->response->json($admin);
    }
}
