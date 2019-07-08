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

use Magento\Framework\Exception\LocalizedException;

/**
 * Class EmailNotify
 * @package Mageplaza\CronSchedule\Model
 */
class Schedule extends \Magento\Cron\Model\Schedule
{
    /**
     * @throws LocalizedException
     */
    public function clearLog()
    {
        $collection = $this->getResourceCollection();

        $collection->getConnection()->truncateTable($collection->getMainTable());
    }
}
