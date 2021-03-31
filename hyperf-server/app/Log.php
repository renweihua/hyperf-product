<?php

namespace App;

use Hyperf\Logger\Logger;
use Hyperf\Utils\ApplicationContext;

/**
 * Class Log
 *
 * 封装 Log 类
 *
 * @package App
 */
class Log
{
    // 默认使用 Channel 名为 app 来记录日志，您也可以通过使用 Log::get($name) 方法获得不同 Channel 的 Logger
    public static function get(string $name = 'app')
    {
        return ApplicationContext::getContainer()->get(\Hyperf\Logger\LoggerFactory::class)->get($name);
    }
}
