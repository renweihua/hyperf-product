<?php

declare (strict_types = 1);

namespace App\Model\System;

use App\Model\MonthModel;
use App\Model\User\UserInfo;

class Notify extends MonthModel
{
    protected $primaryKey = 'notify_id';

    public function user()
    {
        return $this->hasOne(UserInfo::class, 'user_id', 'user_id');
    }
}