<?php

declare(strict_types=1);

namespace App\Listener\Admin;

use App\Event\Admin\AdminLoginEvent;
use App\Model\Log\AdminLoginLog;
use Hyperf\Event\Annotation\Listener;
use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * @Listener
 */
class AdminLoginListener implements ListenerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function listen(): array
    {
        return [
            AdminLoginEvent::class,
        ];
    }

    /**
     * 通过注解注册监听器
     *
     * @param AdminLoginEvent $event
     */
    public function process(object $event)
    {
        // 事件触发后该监听器要执行的代码写在这里，比如该示例下的发送用户注册成功短信等
        // 直接访问 $event 的 admin 属性获得事件触发时传递的参数值
        // $event->admin;

        // var_dump('AdminLoginListener - process');

        // 登录日志
        AdminLoginLog::getInstance()->record($event->request, $event->admin->admin_id ?? 0);
    }
}
