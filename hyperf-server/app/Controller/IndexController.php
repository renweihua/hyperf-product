<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller;

use App\Model\App;
use App\Request\Admin\AppRequest;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * Class IndexController
 *
 * @Controller()
 *
 * @package App\Controller
 */
class IndexController extends AbstractController
{
    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }

    /**
     * 获取访问Api的Token
     *
     * @param  \App\Request\Admin\AppRequest  $appRequest
     *
     * @return array
     */
    public function getApiToken(AppRequest $appRequest)
    {
        $data = $appRequest->validated();

        if ($app = App::query()->where([
            'app_key' => $data['app_key'],
            'app_secret' => $data['app_secret'],
        ])->first()) {
            if ($app->app_type != $data['app_type']) {
                return $this->error('APP权限不足！');
            }else{
                // 通过 App 的数据返回Token
                return $this->success($app);
            }
        }else{
            return $this->error('APP的Key与秘钥不匹配！');
        }
    }
}
