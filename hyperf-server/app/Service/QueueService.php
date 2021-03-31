<?php

declare(strict_types = 1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Service;

use Psr\Container\ContainerInterface;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Driver\DriverInterface;
use Hyperf\Di\Annotation\Inject;

class QueueService extends Service
{
    /**
     * @Inject()
     * @var DriverFactory
     */
    protected $driverFactory;

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * Redis Driver 驱动名称（async_queue对应的key）
     * @var string
     */
    protected $driver_name = 'query-list';

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->driver = $this->driverFactory->get($this->driver_name);
    }

    /**
     * 生成消息：追加到Redis
     *
     * @param       $params 数据
     * @param  int  $delay 延时时间 单位秒
     *
     * @return bool
     */
    public function push($job, int $delay = 0) : bool
    {
        // 这里的 `ExampleJob` 会被序列化存到 Redis 中，所以内部变量最好只传入普通数据
        // 同理，如果内部使用了注解 @Value 会把对应对象一起序列化，导致消息体变大。
        // 所以这里也不推荐使用 `make` 方法来创建 `Job` 对象。
        return $this->driver->push($job, $delay);
    }
}