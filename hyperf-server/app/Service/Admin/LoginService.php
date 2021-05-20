<?php

namespace App\Service\Admin;

use App\Constants\CacheKey;
use App\Event\Admin\AdminLoginEvent;
use App\Exception\Exception;
use App\Library\Encrypt\Rsa;
use App\Model\Rabc\Admin;
use App\Service\Service;
use Hyperf\Di\Annotation\Inject;
use Psr\EventDispatcher\EventDispatcherInterface;

class LoginService extends Service
{
    /**
     * @Inject()
     * @var Admin
     */
    private $admin;

    /**
     * @Inject
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * 用户登录
     *
     * @param  string  $username
     *
     * @return mixed
     */
    public function login($request, string $username, string $password)
    {
        $admin = $this->admin->getUserByName($username);
        if ( !$admin ) throw new Exception('管理员账户不存在');
        if ( !hash_verify($password, $admin->password) ) throw new Exception('管理员信息不匹配');
        switch ($admin->is_check) {
            case 0:
                throw new Exception('该管理员尚未启用');
                break;
            case 2:
                throw new Exception('该管理员已禁用');
                break;
        }

        // 事件需要通过 事件调度器(EventDispatcher) 调度才能让 监听器(Listener) 监听到
        // 这里 dispatch(object $event) 会逐个运行监听该事件的监听器
        $this->eventDispatcher->dispatch(new AdminLoginEvent($request, $admin));

        $data = $this->getTokenFormat($admin);
        $token = Rsa::publicEncrypt($data);

        return [
            'access_token' => $token,
            'expire_time' => $data['expire_time'],
        ];
    }

    public function getTokenFormat($admin) : array
    {
        return ['admin_id' => $admin->admin_id, 'guard' => 'admin', 'expire_time' => time() + CacheKey::KEY_DEFAULT_TIMEOUT];
    }

    public function me($admin_id)
    {
        $admin = $this->admin->find($admin_id);
        return [
            'avatar'      => "https://i.gtimg.cn/club/item/face/img/2/15922_100.gif",
            'username'    => $admin->admin_name,
            'permissions' => ['admin'],
            'roles'       => ['admin'],
        ];
    }
}
