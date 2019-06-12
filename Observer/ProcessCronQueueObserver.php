<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_CronSchedule
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\CronSchedule\Observer;

use Magento\Cron\Model\ConfigInterface;
use Magento\Cron\Model\ScheduleFactory;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Console\Request;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Process\PhpExecutableFinderFactory;
use Magento\Framework\ShellInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Mageplaza\CronSchedule\Helper\Data;

/**
 * Class ProcessCronQueueObserver
 * @package Mageplaza\CronSchedule\Observer
 */
class ProcessCronQueueObserver extends \Magento\Cron\Observer\ProcessCronQueueObserver
{
    /**
     * @var Data
     */
    private $helper;

    /**
     * ProcessCronQueueObserver constructor.
     *
     * @param ObjectManagerInterface $objectManager
     * @param ScheduleFactory $scheduleFactory
     * @param CacheInterface $cache
     * @param ConfigInterface $config
     * @param ScopeConfigInterface $scopeConfig
     * @param Request $request
     * @param ShellInterface $shell
     * @param TimezoneInterface $timezone
     * @param PhpExecutableFinderFactory $phpExecutableFinderFactory
     * @param Data $helper
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ScheduleFactory $scheduleFactory,
        CacheInterface $cache,
        ConfigInterface $config,
        ScopeConfigInterface $scopeConfig,
        Request $request,
        ShellInterface $shell,
        TimezoneInterface $timezone,
        PhpExecutableFinderFactory $phpExecutableFinderFactory,
        Data $helper
    ) {
        $this->helper = $helper;

        parent::__construct(
            $objectManager,
            $scheduleFactory,
            $cache,
            $config,
            $scopeConfig,
            $request,
            $shell,
            $timezone,
            $phpExecutableFinderFactory
        );
    }

    /**
     * @param string $jobCode
     * @param string $cronExpression
     * @param int $timeInterval
     * @param array $exists
     *
     * @return void
     */
    protected function saveSchedule($jobCode, $cronExpression, $timeInterval, $exists)
    {
        if ($this->helper->isJobDisabled($jobCode)) {
            return;
        }

        parent::saveSchedule($jobCode, $cronExpression, $timeInterval, $exists);
    }
}
