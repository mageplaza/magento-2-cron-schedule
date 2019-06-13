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

use Mageplaza\CronSchedule\Helper\Data;

/**
 * Class ProcessCronQueueObserver
 * @package Mageplaza\CronSchedule\Observer
 */
class ProcessCronQueueObserver extends \Magento\Cron\Observer\ProcessCronQueueObserver
{
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
}
