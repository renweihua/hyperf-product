<?php

declare(strict_types = 1);

namespace App\Model\Bbs;

use App\Model\Model;
use App\Model\User\UserInfo;

class BbsDynamicComment extends Model
{
    public $is_delete = 1;// 是否删除：0.假删除；1.真删除【默认全部假删除】

    public function getCommentContentAttribute($value)
    {
        return html_entity_decode(htmlspecialchars_decode($value));
    }

    public function setCommentContentAttribute($value)
    {
        $this->attributes['comment_content'] = htmlspecialchars($value);
    }

    public function user()
    {
        return $this->belongsTo(UserInfo::class, 'user_id', 'user_id');
    }

    public function reply()
    {
        return $this->belongsTo(UserInfo::class, 'reply_user', 'user_id');
    }
}