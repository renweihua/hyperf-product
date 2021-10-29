<?php

namespace App\Middleware\Admin;

use App\Constants\StatusConst;
use App\Library\Encrypt\Rsa;
use App\Traits\Json;
use Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;

class TokenAuthMiddleware implements MiddlewareInterface
{
    use Json;

    /**
     * @var HttpResponse
     */
    protected $response;

    public function __construct(HttpResponse $response)
    {
        $this->response = $response;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        // 根据具体业务判断逻辑走向，这里假设用户携带的token有效
        $token = $request->getHeader('Authorization')[0] ?? '';

        // 重新登录的状态码
        $un_login_status = StatusConst::UN_LOGIN;

        if ( strlen($token) <= 0 ) {
            return $this->error('请求头部传参Token：Authorization！', $un_login_status);
        }
        // 解析token
        $admin = Rsa::privDecrypt($token);
        if (empty($admin)) {
            return $this->error('Token已失效！', $un_login_status);
        }
        // 检测Token是否为管理员登录的Token
        if (!isset($admin->guard) || $admin->guard != 'admin' ) {
            return $this->error('无效的Token！', $un_login_status);
        }
        if (!isset($admin->expire_time) || $admin->expire_time < time()){
            return $this->error('Token已过期！', $un_login_status);
        }

        /**
         * 协程上下文：https://hyperf.wiki/2.0/#/zh-cn/coroutine?id=%e5%8d%8f%e7%a8%8b%e4%b8%8a%e4%b8%8b%e6%96%87
         *
         * 避免协程间数据混淆：https://hyperf.wiki/2.0/#/zh-cn/controller?id=%e9%81%bf%e5%85%8d%e5%8d%8f%e7%a8%8b%e9%97%b4%e6%95%b0%e6%8d%ae%e6%b7%b7%e6%b7%86
         */
        $request = Context::get(ServerRequestInterface::class);
        $request = $request->withAttribute('admin_id', $admin->admin_id);
        Context::set(ServerRequestInterface::class, $request);

        unset($token, $admin, $un_login_status);
        return $handler->handle($request);
    }
}
