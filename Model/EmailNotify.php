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
use Mageplaza\CronSchedule\Helper\Email;
use Mageplaza\CronSchedule\Model\ResourceModel\Schedule\Grid\Collection;
use Mageplaza\CronSchedule\Model\ResourceModel\Schedule\Grid\CollectionFactory;
use Zend_Db_Expr;

/**
 * Class EmailNotify
 * @package Mageplaza\CronSchedule\Model
 */
class EmailNotify
{
    /**
     * @var Email
     */
    private $helper;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * EmailNotify constructor.
     *
     * @param Email $helper
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Email $helper,
        CollectionFactory $collectionFactory
    ) {
        $this->helper            = $helper;
        $this->collectionFactory = $collectionFactory;
    }

    public function sendEmail()
    {
        if (!$this->helper->isEmailNotification() || empty($this->helper->getSendTo())) {
            return;
        }

        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        $collection
            ->addFieldToFilter('mpcronschedule_email_sent', ['null' => true])
            ->addFieldToFilter('status', ['in' => [Schedule::STATUS_ERROR, Schedule::STATUS_MISSED]]);

        if (!$collection->getSize()) {
            return;
        }

        $this->helper->sendEmail(['schedules' => $collection]);

        $schedules = array_column($collection->getData(), 'schedule_id');

        $collection->getConnection()->update(
            $collection->getMainTable(),
            ['mpcronschedule_email_sent' => 1],
            [new Zend_Db_Expr('schedule_id IN ( ' . implode(',', $schedules) . ' )')]
        );
    }
}
