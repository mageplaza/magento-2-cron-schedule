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

use Magento\Cron\Model\Schedule;
use Magento\Framework\Notification\MessageInterface;
use Magento\Framework\Phrase;
use Magento\Framework\UrlInterface;
use Mageplaza\CronSchedule\Helper\Data;
use Mageplaza\CronSchedule\Model\ResourceModel\Schedule\Grid\CollectionFactory;

/**
 * Class Message
 * @package Mageplaza\CronSchedule\Model
 */
class Message implements MessageInterface
{
    /**
     * @var Data
     */
    private $helper;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * Message constructor.
     *
     * @param Data $helper
     * @param UrlInterface $urlBuilder
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Data $helper,
        UrlInterface $urlBuilder,
        CollectionFactory $collectionFactory
    ) {
        $this->helper            = $helper;
        $this->urlBuilder        = $urlBuilder;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Retrieve unique message identity
     *
     * @return string
     */
    public function getIdentity()
    {
        return sha1('MPCRONSCHEDULE_ERROR_MESSAGE');
    }

    /**
     * Check whether
     *
     * @return bool
     */
    public function isDisplayed()
    {
        $collection = $this->collectionFactory->create();

        $collection->addFieldToFilter('status', ['in' => [Schedule::STATUS_ERROR, Schedule::STATUS_MISSED]]);

        return $this->helper->isBackendNotification() && $collection->getSize();
    }

    /**
     * Retrieve message text
     *
     * @return Phrase|string
     */
    public function getText()
    {
        return __(
            'One or more cron jobs can not execute successfully! Click <a href="%1">here</a> to see more details.',
            $this->urlBuilder->getUrl('mpcronschedule/log/index')
        );
    }

    /**
     * Retrieve message severity
     *
     * @return int
     */
    public function getSeverity()
    {
        return self::SEVERITY_MAJOR;
    }
}
