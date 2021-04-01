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

use App\Constants\CacheKey;
use App\Library\Encrypt\Aes;
use App\Model\App;
use App\Request\Admin\AppRequest;
use Hyperf\HttpServer\Annotation\Controller;

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
                $expire_time = time() + CacheKey::KEY_DEFAULT_TIMEOUT;
                $encryption_data = [
                    'app_key' => $app->app_key,
                    'md5_secret' => md5($app->app_secret),
                    'expire_time' => $expire_time,
                ];
                $aes = new Aes;
                $token = $aes->encrypt($encryption_data);

                return $this->success(compact('token', 'expire_time'));
            }
        }else{
            return $this->error('APP的Key与秘钥不匹配！');
        }
    }
}
