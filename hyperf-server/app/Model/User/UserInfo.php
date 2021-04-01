<?php

declare(strict_types = 1);

namespace App\Model\User;

use App\Model\Model;
use App\Model\Upload\UploadFile;

class UserInfo extends Model
{
    protected $primaryKey = 'user_id';
    public    $is_delete  = 1;// 是否删除：0.假删除；1.真删除【默认全部假删除】

    /**
     * 关联图片模型：获取头像地址
     *
     * @return \Hyperf\Database\Model\Relations\HasOne
     */
    public function avatar()
    {
        return $this->hasOne(UploadFile::class, 'file_id', 'user_avatar');
    }

    public function user()
    {
        $key = $this->getKeyName();
        return $this->hasOne(User::class, $key, $key);
    }

    public function register(int $user_id, array $data = [])
    {
        return $this->add(['user_id' => $user_id, 'nick_name' => $data['user_name'], 'user_uuid' => get_uuid(),]);
    }

    /**
     * 通过UUID进行搜索
     *
     * @param  string  $user_uuid
     *
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|object|null
     */
    public function getUserByUuid(string $user_uuid, array $with = [])
    {
        return $this->query()->where('user_uuid', $user_uuid)->with($with)->first();
    }

    public function detail(int $user_id, array $with = ['avatar'])
    {
        return $this->find($user_id, $with);
    }
}