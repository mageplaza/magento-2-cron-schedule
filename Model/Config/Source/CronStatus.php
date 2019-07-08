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

namespace Mageplaza\CronSchedule\Model\Config\Source;

use Magento\Cron\Model\Schedule;

/**
 * Class CronStatus
 * @package Mageplaza\CronSchedule\Model\Config\Source
 */
class CronStatus extends AbstractSource
{
    /**
     * @return array
     */
    public static function getOptionArray()
    {
        return [
            Schedule::STATUS_PENDING => __('Pending'),
            Schedule::STATUS_RUNNING => __('Running'),
            Schedule::STATUS_SUCCESS => __('Success'),
            Schedule::STATUS_MISSED  => __('Missed'),
            Schedule::STATUS_ERROR   => __('Error'),
        ];
    }
}
