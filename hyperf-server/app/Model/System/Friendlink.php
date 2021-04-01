<?php

declare (strict_types = 1);

namespace App\Model\System;

use App\Model\Model;
use App\Model\Upload\UploadFile;

/**
 */
class Friendlink extends Model
{
    protected $primaryKey = 'link_id';

    public function cover()
    {
        return $this->hasOne(UploadFile::class, 'file_id', 'link_img');
    }
}