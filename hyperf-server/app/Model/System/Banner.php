<?php

declare (strict_types = 1);

namespace App\Model\System;

use App\Model\Model;
use App\Model\Upload\UploadFile;

/**
 */
class Banner extends Model
{
    protected $primaryKey = 'banner_id';

    public function cover()
    {
        return $this->hasOne(UploadFile::class, 'file_id', 'banner_cover');
    }
}