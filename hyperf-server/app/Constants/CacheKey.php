<?php

declare(strict_types = 1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * 状态码的定义
 *
 * @Constants
 */
class CacheKey extends AbstractConstants
{
    // 默认过期时间
    const KEY_DEFAULT_TIMEOUT = 3600;
}
