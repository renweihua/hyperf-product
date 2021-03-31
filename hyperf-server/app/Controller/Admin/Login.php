<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Event\Admin\AdminLoginEvent;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\Di\Annotation\Inject;
use Psr\EventDispatcher\EventDispatcherInterface;

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
    public function index()
    {
        $admin = [
            'admin_id' => 1,
            'admin_name' => 'cnpscy',
        ];

        // 事件需要通过 事件调度器(EventDispatcher) 调度才能让 监听器(Listener) 监听到
        // 这里 dispatch(object $event) 会逐个运行监听该事件的监听器
        $this->eventDispatcher->dispatch(new AdminLoginEvent($admin));

        return $admin;
    }
}
