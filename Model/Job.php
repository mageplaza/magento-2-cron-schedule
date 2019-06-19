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

namespace Mageplaza\CronSchedule\Model;

use Exception;
use Magento\Cron\Model\Schedule;
use Magento\Framework\App\Config\Value;
use Magento\Framework\App\Config\ValueFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Mageplaza\CronSchedule\Helper\Data;
use RuntimeException;

/**
 * Class Job
 * @package Mageplaza\CronSchedule\Model
 * @method getName()
 * @method getGroup()
 * @method getInstance()
 * @method getMethod()
 * @method getSchedule()
 * @method getStatus()
 * @method getIsUser()
 */
class Job extends AbstractModel
{
    const CRON_PATH    = 'crontab/{$group}/jobs/{$name}/';
    const EXPR_PATH    = self::CRON_PATH . 'schedule/cron_expr';
    const MODEL_PATH   = self::CRON_PATH . 'run/model';
    const STATUS_PATH  = self::CRON_PATH . 'status';
    const IS_USER_PATH = self::CRON_PATH . 'is_user';

    /**
     * @var Data
     */
    private $helper;

    /**
     * @var ValueFactory
     */
    private $valueFactory;

    /**
     * Job constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param Data $helper
     * @param ValueFactory $valueFactory
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        Data $helper,
        ValueFactory $valueFactory,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->helper       = $helper;
        $this->valueFactory = $valueFactory;

        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * @param Job $newObject
     *
     * @return $this
     * @throws Exception
     */
    public function saveJob($newObject)
    {
        $vars = [
            self::EXPR_PATH    => $newObject->getSchedule(),
            self::MODEL_PATH   => $newObject->getInstance() . '::' . $newObject->getMethod(),
            self::STATUS_PATH  => $newObject->getStatus(),
            self::IS_USER_PATH => $newObject->getIsUser()
        ];

        foreach ($vars as $path => $value) {
            /** @var Value $config */
            $config = $this->valueFactory->create();
            $config->load($this->getCronPath($path), 'path');
            $config->setPath($newObject->getCronPath($path));
            $config->setValue($value);
            $config->save();
        }

        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function deleteJob()
    {
        foreach ([self::EXPR_PATH, self::MODEL_PATH, self::STATUS_PATH, self::IS_USER_PATH] as $path) {
            /** @var Value $config */
            $config = $this->valueFactory->create();
            $config->load($this->getCronPath($path), 'path')->delete();
        }

        return $this;
    }

    /**
     * @param Schedule $schedule
     *
     * @return $this
     * @throws RuntimeException
     * @throws Exception
     */
    public function executeJob(&$schedule)
    {
        $instance = $this->getInstance();
        $method   = $this->getMethod();

        if (!isset($instance, $method)) {
            throw new RuntimeException(__('No callbacks found'));
        }

        $model = $this->helper->createObject($instance);

        $callback = [$model, $method];

        if (!is_callable($callback)) {
            throw new RuntimeException(sprintf('Invalid callback: %s::%s can\'t be called', $instance, $method));
        }

        $schedule->setExecutedAt($this->helper->getTime());

        $model->{$method}($schedule);

        $schedule->setFinishedAt($this->helper->getTime());

        return $this;
    }

    /**
     * @param bool $statusValue
     *
     * @return Job
     * @throws Exception
     */
    public function changeJobStatus($statusValue)
    {
        /** @var Value $config */
        $config = $this->valueFactory->create();
        $config->load($this->getCronPath(self::STATUS_PATH), 'path');
        $config->setValue($statusValue);
        $config->save();

        return $this;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getCronPath($path)
    {
        return str_replace(['{$group}', '{$name}'], [$this->getGroup(), $this->getName()], $path);
    }
}
