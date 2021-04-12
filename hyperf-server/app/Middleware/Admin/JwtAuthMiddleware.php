<?php
/**
 * This file is form http://findcat.cn
 *
 * @link     http://findcat.cn
 * @email    1476982312@qq.com
 */

namespace App\Middleware\Admin;

use App\Constants\StatusConst;
use Phper666\JWTAuth\Exception\TokenValidException;
use Phper666\JWTAuth\JWT;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;

class JwtAuthMiddleware implements MiddlewareInterface
{
    /**
     * @var HttpResponse
     */
    protected $response;
    protected $prefix = 'Bearer';
    protected $jwt;

    public function __construct(HttpResponse $response, Jwt $jwt)
    {
        $this->response = $response;
        $this->jwt = $jwt;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        // 根据具体业务判断逻辑走向，这里假设用户携带的token有效
        $token = $request->getHeader('Authorization')[0] ?? '';

        // 重新登录的状态码
        $un_login_status = StatusConst::UN_LOGIN;

        if ( strlen($token) <= 0 ) {
            return $this->response->json(['message' => '请求头部传参Token：Authorization', 'status' => $un_login_status, 'data' => []]);
        }

        // 验证Token
        if ( $this->jwt->checkToken() ) {
            // 解析token
            $admin = $this->jwt->getParserData();
            if ( !$admin ) {
                return $this->response->json(['message' => 'Token已失效', 'status' => $un_login_status, 'data' => []]);
            }
            // 检测Token是否为管理员登录的Token
            if ( $admin['guard'] != 'admin' ) {
                return $this->response->json(['message' => '无效的Token', 'status' => $un_login_status, 'data' => []]);
            }

            $request->admin = $admin;

            unset($token, $admin, $isValidToken);
            return $handler->handle($request);
        }

        return $this->response->json(['message' => 'Token已失效', 'status' => $un_login_status, 'data' => []]);
    }
}
