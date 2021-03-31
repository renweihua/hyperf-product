<?php

declare(strict_types=1);

namespace App\Command;

use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Psr\Container\ContainerInterface;
use Hyperf\Crontab\Annotation\Crontab;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Di\Annotation\Inject;

/**
 * Class AutoTableBuild
 *
 * 通过注解定义，触发定时任务
 *
 * @Crontab(name="AutoTableBuild", rule="30 1 1 * *", callback="execute", memo="Automatically create Month by month table|自动创建按月分表")
 *
 * @package App\Command
 */
class AutoTableBuild extends HyperfCommand
{
    /**
     * @Inject()
     * @var LoggerFactory
     */
    protected $loggerFactory;

    /**
     * @var ContainerInterface
     */
    protected $container;

    private $logger;

    // 自动创建按月分表的定义
    private $tabel_list = [

    ];

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct('demo:command');

        // 第一个参数对应日志的 name, 第二个参数对应 config/autoload/logger.php 内的 key
        $this->logger = $this->loggerFactory->get('log', 'crontab');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('Hyperf Demo Command');
    }

    public function handle()
    {
        $this->logger->info('auto_table_build - 自动按月分表 - start');

        foreach ($this->tabel_list as $table) {
            (new $table)->createMonthTable('', strtotime('+1 month'));
        }

        $this->logger->info('auto_table_build - 自动按月分表 - end');
    }
}
