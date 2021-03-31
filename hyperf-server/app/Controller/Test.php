<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\Paginator\Paginator;
use Hyperf\Utils\Collection;

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

    /**
     * @RequestMapping(path="/paginator", methods="get")
     */
    public function paginator()
    {
        $currentPage = (int) $this->request->input('page', 1);
        $perPage = (int) $this->request->input('per_page', 2);

        // 这里根据 $currentPage 和 $perPage 进行数据查询，以下使用 Collection 代替
        $collection = new Collection([
            ['id' => 1, 'name' => 'Tom'],
            ['id' => 2, 'name' => 'Sam'],
            ['id' => 3, 'name' => 'Tim'],
            ['id' => 4, 'name' => 'Joe'],
        ]);

        $users = array_values($collection->forPage($currentPage, $perPage)->toArray());

        return new Paginator($users, $perPage, $currentPage);
    }
}
