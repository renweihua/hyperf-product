<?php

declare(strict_types = 1);

namespace App\Controller\Admin;

use App\Model\MonthModel;
use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\IndexService;
use Psr\Http\Message\ResponseInterface;

class Index extends BaseController
{

    /**
     * @Inject
     * @var IndexService
     */
    protected $service;

    /**
     * 首页统计
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(): ResponseInterface
    {
        return $this->success($this->service->index());
    }

    /**
     * 获取所有的月份列表
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getMonthList(): ResponseInterface
    {
        return $this->success(MonthModel::getInstance()->getAllMonthes());
    }
}
