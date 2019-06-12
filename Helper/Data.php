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

use Magento\Cron\Model\Config\Reader\Db;
use Magento\Cron\Model\Config\Reader\Xml;
use Magento\Cron\Model\ConfigInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\ObjectManagerInterface;
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
     * @var array
     */
    protected $_jobs = [];

    /**
     * @var Db
     */
    private $dbReader;

    /**
     * @var Xml
     */
    private $xmlReader;

    /**
     * @var ConfigInterface
     */
    private $cronConfig;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param ObjectManagerInterface $objectManager
     * @param StoreManagerInterface $storeManager
     * @param Db $dbReader
     * @param Xml $xmlReader
     * @param ConfigInterface $cronConfig
     */
    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager,
        Db $dbReader,
        Xml $xmlReader,
        ConfigInterface $cronConfig
    ) {
        $this->dbReader   = $dbReader;
        $this->xmlReader  = $xmlReader;
        $this->cronConfig = $cronConfig;

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
     * @param null $name
     *
     * @return array
     */
    public function getJobs($name = null)
    {
        if (isset($this->_jobs[$name])) {
            return $this->_jobs[$name];
        }

        if (!$name && $this->_jobs) {
            return $this->_jobs;
        }

        foreach ($this->cronConfig->getJobs() as $group => $jobs) {
            foreach ((array) $jobs as $code => $job) {
                if (!isset($job['name'], $job['instance'], $job['method'])) {
                    continue;
                }

                if (!$name) {
                    $this->_jobs[$code] = $this->getJobData($job, $code, $group);
                } elseif ($name === $code) {
                    return $this->getJobData($job, $code, $group);
                }
            }
        }

        return $this->_jobs;
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
        $job['group'] = $group;
        $job['type']  = $this->getJobType($code, $group);

        if (!isset($job['schedule'])) {
            $job['schedule'] = '';

            if (isset($job['config_path'])) {
                $job['schedule'] = $this->scopeConfig->getValue($job['config_path'], ScopeInterface::SCOPE_STORE);
            }
        }

        if (!isset($job['status'])) {
            $job['status'] = 1;
        }

        if (!isset($job['is_user'])) {
            $job['is_user'] = 0;
        }

        return $job;
    }

    /**
     * @param string $code
     * @param string $group
     *
     * @return string
     */
    private function getJobType($code, $group)
    {
        $xml = isset($this->xmlReader->read()[$group][$code]);
        $db  = isset($this->dbReader->get()[$group][$code]);

        if ($xml && $db) {
            return 'db_xml';
        }

        if ($db) {
            return 'db';
        }

        if ($xml) {
            return 'xml';
        }

        return '';
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function isJobDisabled($name)
    {
        $job = $this->getJobs($name);

        return isset($job['status']) && empty($job['status']);
    }
}
