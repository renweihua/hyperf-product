<?php

declare(strict_types = 1);

namespace App\Model\Bbs;

use App\Model\Model;
use App\Model\User\UserInfo;

class BbsDynamic extends Model
{
    protected $primaryKey = 'dynamic_id';

    public function getDynamicContentAttribute($value)
    {
        return html_entity_decode(htmlspecialchars_decode($value));
    }

    public function setDynamicContentAttribute($value)
    {
        $this->attributes['dynamic_content'] = htmlspecialchars($value);
    }

    public function publish(int $user_id, $data)
    {
        return $this->add(array_merge(['user_id' => $user_id], $data));
    }

    public function remove($id)
    {
        return $this->batch_delete($id);
    }

    public function user()
    {
        return $this->belongsTo(UserInfo::class, 'user_id');
    }

    public function praises()
    {
        return $this->hasMany(BbsDynamicPraise::class, 'dynamic_id');
    }

    public function collections()
    {
        return $this->hasMany(BbsDynamicCollection::class, 'dynamic_id');
    }

    public function comments()
    {
        // 只需要关联查询出主层级的动态
        return $this->hasMany(BbsDynamicComment::class, 'dynamic_id');
    }

    /**
     * 检测动态是否存在
     *
     * @param  int  $dynamic_id
     *
     * @return bool
     */
    public static function check(int $dynamic_id) : bool
    {
        return self::find($dynamic_id) ? true : false;
    }

    /**
     * 获取作者
     *
     * @param  int  $dynamic_id
     *
     * @return int
     */
    public function getAuthor(int $dynamic_id) : int
    {
        return $this->cnpscyWhere('dynamic_id', $dynamic_id)->value('user_id') ?? 0;
    }
}