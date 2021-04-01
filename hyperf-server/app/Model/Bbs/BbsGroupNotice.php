<?php

declare(strict_types = 1);

namespace App\Model\Bbs;

use App\Model\Model;

class BbsGroupNotice extends Model
{
    public function getNoticeContentAttribute($value)
    {
        return html_entity_decode(htmlspecialchars_decode($value));
    }

    public function setNoticeContentAttribute($value)
    {
        $this->attributes['notice_content'] = htmlspecialchars($value);
    }
}