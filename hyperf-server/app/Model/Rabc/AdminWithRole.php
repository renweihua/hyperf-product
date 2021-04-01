<?php

declare (strict_types = 1);

namespace App\Model\Rabc;

use App\Model\Model;

class AdminWithRole extends Model
{
    protected $primaryKey = 'with_id';
    public    $timestamps = false;
    public    $is_delete  = 1;// 是否删除：0.假删除；1.真删除【默认全部假删除】
}