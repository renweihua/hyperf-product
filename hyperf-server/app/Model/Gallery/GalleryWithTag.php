<?php

namespace App\Model\Gallery;

use App\Model\Model;
use App\Model\Rabc\AdminMenu;

class GalleryWithTag extends Model
{
    public $timestamps = false;
    public    $is_delete    = 1;// 是否删除：0.假删除；1.真删除【默认全部假删除】
}