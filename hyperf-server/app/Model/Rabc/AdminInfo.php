<?php

declare (strict_types = 1);

namespace App\Model\Rabc;

use App\Model\Model;
use Hyperf\Database\Model\Events\Creating;

class AdminInfo extends Model
{
    protected $primaryKey = 'admin_id';
//    protected $appends    = ['abcd'];
    public    $is_delete  = 1;// 是否删除：0.假删除；1.真删除【默认全部假删除】

//    public function getAbcdAttribute($value)
//    {
//        return 'admininfo-abcd';
//    }

    public function creating(Creating $event)
    {
        /**
         * IP 与 浏览器信息
         */
        $ip_agent = get_client_info();

        $this->created_ip = $ip_agent['ip'] ?? get_ip();
        $this->browser_type = $ip_agent['agent'] ?? ($_SERVER['HTTP_USER_AGENT'] ?? '');
    }
}
