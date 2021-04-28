<?php

declare(strict_types = 1);

namespace App\Controller\Admin;

use App\Model\MonthModel;

class Index extends BaseController
{
    /**
     * 获取所有的月份列表
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getMonthList()
    {
        return $this->success(MonthModel::getInstance()->getAllMonthes());
    }
}
