<?php

declare(strict_types=1);

namespace App\Middleware\Api;

use App\Model\Log\VisitRecord;
use App\Traits\Json;
use Exception;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VisitRecordMiddleware implements MiddlewareInterface
{
    use Json;

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $user_id = 0;
        // $token = $request->getHeader('api-token')[0] ?? '';
        // if($token = $request->getHeader('Authorization')){
        //     $token_user = Rsa::privDecrypt($token);
        //     if ($token_user){
        //         $user_id = $token_user->user_id ?? 0;
        //     }
        // }

        
        $server_params = $request->getServerParams();;
        // 录入浏览记录
        $visit_record = VisitRecord::create(
            [
                'user_id'   => $user_id,
                'request_data' => $server_params,
                'created_ip'   => \Hyperf\Utils\Network::ip(),
                'browser_type' => current($request->getHeader('user-agent')),
                'created_time' => time(),
                'api_url'   => $request->fullUrl(),
                'log_method'   => $request->getMethod(),
                'log_duration' => microtime(true) - $server_params['request_time_float'],
                // 默认值
                'log_status'   => 0,
                'log_description'   => '异常中断',
            ]
        );

        $log_status = 0;
        $log_description = $visit_record->log_description;
        try{
            $response = $handler->handle($request);
        
            // 获取返回content内容
            $response_body_content = json_decode($response->getBody()->getContents());

            // 根据接口响应，存储返回状态与文本提示语
            $log_status = $response_body_content->status;
            $log_description = $response_body_content->msg;
        }catch(Exception $e){
            $log_description = $e->getMessage();
            $response = $this->error($log_description);
        }

        // 同步更新响应状态与文本，在`handler`层可能会被异常终止
        $visit_record->update(
            [
                'log_duration' => microtime(true) - $server_params['request_time_float'],
                // 根据接口响应，存储返回状态与文本提示语
                'log_status'   => $log_status,
                'log_description'   => $log_description,
            ]
        );

        return $response;
    }
}