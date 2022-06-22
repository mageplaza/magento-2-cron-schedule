<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the mageplaza.com license that is
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

namespace Mageplaza\CronSchedule\Helper;

use DateTime as BaseDateTime;
use DateTimeZone;
use Exception;
use Magento\Cron\Model\ConfigInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mageplaza\Core\Helper\AbstractData;

/**
 * Class Data
 * @package Mageplaza\CronSchedule\Helper
 */
class Data extends AbstractData
{
    const CONFIG_MODULE_PATH = 'mpcronschedule';

    /**
     * @var ConfigInterface
     */
    private $cronConfig;

    /**
     * @var TimezoneInterface
     */
    private $timezone;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @var string
     */
    private $locale;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param ObjectManagerInterface $objectManager
     * @param StoreManagerInterface $storeManager
     * @param ConfigInterface $cronConfig
     * @param TimezoneInterface $timezone
     * @param DateTime $dateTime
     */
    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager,
        ConfigInterface $cronConfig,
        ResolverInterface $localeResolver,
        TimezoneInterface $timezone,
        DateTime $dateTime
    ) {
        $this->cronConfig = $cronConfig;
        $this->timezone   = $timezone;
        $this->dateTime   = $dateTime;
        $this->locale     = $localeResolver->getLocale();

        parent::__construct($context, $objectManager, $storeManager);
    }

    /**
     * @param null $storeId
     *
     * @return bool
     */
    public function isBackendNotification($storeId = null)
    {
        return (bool) $this->getConfigGeneral('backend_notification', $storeId);
    }

    /**
     * @param null $storeId
     *
     * @return int
     */
    public function getClearSchedule($storeId = null)
    {
        return (int) $this->getConfigGeneral('clear_schedule', $storeId);
    }

    /**
     * @param null $name
     *
     * @return array
     */
    public function getJobs($name = null)
    {
        $data = [];

        foreach ($this->cronConfig->getJobs() as $group => $jobs) {
            foreach ((array) $jobs as $code => $job) {
                if (!isset($job['instance'], $job['method'])) {
                    continue;
                }

                if (!$name) {
                    $data[$code] = $this->getJobData($job, $code, $group);
                } elseif ($name === $code) {
                    return $this->getJobData($job, $code, $group);
                }
            }
        }

        return $data;
    }

    /**
     * @param array $job
     * @param string $code
     * @param string $group
     *
     * @return array
     */
    private function getJobData($job, $code, $group)
    {
        $job['name']  = $code;
        $job['group'] = $group;

        if (!isset($job['schedule'])) {
            $job['schedule'] = '';

            if (isset($job['config_path'])) {
                $job['schedule'] = $this->scopeConfig->getValue($job['config_path'], ScopeInterface::SCOPE_STORE);
            }
        }

        if (!isset($job['status'])) {
            $job['status'] = '1';
        }

        if (!isset($job['is_user'])) {
            $job['is_user'] = '0';
        }

        return $job;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function isJobDisabled($name)
    {
        $jobData = $this->getJobs($name);

        return isset($jobData['status']) && empty($jobData['status']);
    }

    /**
     * @param bool $isFloor
     *
     * @return string
     */
    public function getTime($isFloor = false)
    {
        $time   = $this->versionCompare('2.2.0') ? $this->dateTime->gmtTimestamp() : $this->timezone->scopeTimeStamp();
        $format = $isFloor ? 'Y-m-d H:i:00' : 'Y-m-d H:i:s';

        return date($format, $time);
    }

    /**
     * @param string $date
     * @return string
     * @throws Exception
     */
    public function convertedDate($date)
    {
        $convertedDate = $this->timezone->date(
            new BaseDateTime($date, new DateTimeZone('UTC')),
            $this->locale,
            true
        );

        return $convertedDate->format('M j, Y h:i:s A');
    }
}
