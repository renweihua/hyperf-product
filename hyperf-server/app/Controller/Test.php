<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * Class Test
 *
 * @Controller()
 *
 * @package App\Controller
 */
class Test extends AbstractController
{
    /**
     * 注解路由实现：
     *  path="test"，访问路径：控制器/path
     *  path="/test"，访问路径：/path
     *
     * methods 来规定请求方式类型
     *
     * @RequestMapping(path="/test", methods="get")
     */
    public function index()
    {
        return $this->response->json(['data' => 'Hello Hyperf!']);
    }
}
