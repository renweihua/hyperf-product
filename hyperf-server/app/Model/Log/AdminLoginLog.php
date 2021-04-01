<?php

declare (strict_types = 1);

namespace App\Model\Log;

use App\Model\MonthModel;

/**
 */
class AdminLoginLog extends MonthModel
{
    protected $primaryKey = 'log_id';
    public    $is_delete  = 1;// 是否删除：0.假删除；1.真删除【默认全部假删除】
}