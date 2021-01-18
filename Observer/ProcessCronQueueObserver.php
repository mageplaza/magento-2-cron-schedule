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

use DateTime as DateTimeInterface;
use DateTimeZone;
use Exception;
use Magento\Cron\Model\ConfigInterface;
use Magento\Cron\Model\DeadlockRetrierInterface;
use Magento\Cron\Model\Schedule;
use Magento\Cron\Model\ScheduleFactory;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Console\Request;
use Magento\Framework\App\State;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\Lock\LockManagerInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Process\PhpExecutableFinderFactory;
use Magento\Framework\Profiler\Driver\Standard\StatFactory;
use Magento\Framework\ShellInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Store\Model\ScopeInterface;
use Mageplaza\CronSchedule\Helper\Data;
use Psr\Log\LoggerInterface;

/**
 * Class ProcessCronQueueObserver
 * @package Mageplaza\CronSchedule\Observer
 */
class ProcessCronQueueObserver extends \Magento\Cron\Observer\ProcessCronQueueObserver
{
    /**
     * @var TimezoneInterface
     */
    private $localeDate;

    /**
     * @var string
     */
    private $locale;

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
     * @param DateTime $dateTime
     * @param PhpExecutableFinderFactory $phpExecutableFinderFactory
     * @param LoggerInterface $logger
     * @param State $state
     * @param StatFactory $statFactory
     * @param LockManagerInterface $lockManager
     * @param ManagerInterface $eventManager
     * @param DeadlockRetrierInterface $retrier
     * @param TimezoneInterface $localeDate
     * @param ResolverInterface $localeResolver
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ScheduleFactory $scheduleFactory,
        CacheInterface $cache,
        ConfigInterface $config,
        ScopeConfigInterface $scopeConfig,
        Request $request,
        ShellInterface $shell,
        DateTime $dateTime,
        PhpExecutableFinderFactory $phpExecutableFinderFactory,
        LoggerInterface $logger,
        State $state,
        StatFactory $statFactory,
        LockManagerInterface $lockManager,
        ManagerInterface $eventManager,
        DeadlockRetrierInterface $retrier,
        TimezoneInterface $localeDate,
        ResolverInterface $localeResolver
    ) {
        $this->localeDate = $localeDate;
        $this->locale     = $localeResolver->getLocale();

        parent::__construct(
            $objectManager,
            $scheduleFactory,
            $cache,
            $config,
            $scopeConfig,
            $request,
            $shell,
            $dateTime,
            $phpExecutableFinderFactory,
            $logger,
            $state,
            $statFactory,
            $lockManager,
            $eventManager,
            $retrier
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
        // compatible with multiple Magento version
        if ($this->_objectManager->get(Data::class)->isJobDisabled($jobCode)) {
            return;
        }

        parent::saveSchedule($jobCode, $cronExpression, $timeInterval, $exists);
    }

    /**
     * @param int $scheduledTime
     * @param int $currentTime
     * @param string[] $jobConfig
     * @param Schedule $schedule
     * @param string $groupId
     *
     * @throws Exception
     */
    protected function _runJob($scheduledTime, $currentTime, $jobConfig, $schedule, $groupId)
    {
        $jobCode          = $schedule->getJobCode();
        $scheduleLifetime = $this->getCronGroupConfigurationValueCustom($groupId, self::XML_PATH_SCHEDULE_LIFETIME);
        $scheduleLifetime = $scheduleLifetime * self::SECONDS_IN_MINUTE;
        $scheduledAt      = $schedule->getScheduledAt();

        $dataScheduledAt   = $this->localeDate->date(
            new DateTimeInterface($scheduledAt, new DateTimeZone('UTC')),
            $this->locale,
            true
        );

        if ($scheduledTime < $currentTime - $scheduleLifetime) {
            $schedule->setStatus(Schedule::STATUS_MISSED);
            throw new Exception(
                sprintf('Cron Job %s is missed at %s', $jobCode, $dataScheduledAt->format('Y-m-d H:i:s'))
            );
        }

        parent::_runJob($scheduledTime, $currentTime, $jobConfig, $schedule, $groupId);
    }

    /**
     * @param $groupId
     * @param $path
     *
     * @return mixed
     */
    private function getCronGroupConfigurationValueCustom($groupId, $path)
    {
        return $this->_scopeConfig->getValue(
            'system/cron/' . $groupId . '/' . $path,
            ScopeInterface::SCOPE_STORE
        );
    }
}
