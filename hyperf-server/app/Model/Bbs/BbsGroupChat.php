<?php

declare(strict_types = 1);

namespace App\Model\Bbs;

use App\Model\MonthModel;
use App\Model\User\UserInfo;

class BbsGroupChat extends MonthModel
{
    public function getChatContentAttribute($value)
    {
        return html_entity_decode(htmlspecialchars_decode($value));
    }

    public function setChatContentAttribute($value)
    {
        $this->attributes['chat_content'] = htmlspecialchars($value);
    }

    public function user()
    {
        return $this->belongsTo(UserInfo::class, 'user_id', 'user_id');
    }
}