<?php

declare (strict_types = 1);

namespace App\Model\Log;

use App\Model\MonthModel;

/**
 */
class AdminLoginLog extends MonthModel
{
    protected $primaryKey = 'log_id';
    public    $is_delete  = 1;// 是否删除：0.假删除；1.真删除【默认全部假删除】

    public function record($request, int $admin_id = 0, int $log_status = 1, $description = '登录成功')
    {
        $ip_agent = get_client_info();
        return $this->add([
            'admin_id' => $admin_id,
            'created_ip'   => $ip_agent['ip'] ?? get_ip(),
            'browser_type' => $ip_agent['agent'] ?? $_SERVER['HTTP_USER_AGENT'],
            'log_status' => $log_status,
            'description' => $description,
            'log_action'   => $request->getRequestUri(),
            'log_method'   => $request->getMethod(),
            // 'log_duration' => microtime(true) - LARAVEL_START,
            'request_data' => my_json_encode($request->all()),
        ]);
    }
}