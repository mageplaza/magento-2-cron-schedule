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

/**
 * Class EmailTime
 * @package Mageplaza\CronSchedule\Model\Config\Source
 */
class EmailTime extends AbstractSource
{
    const EVERY_10_M = '*/10 * * * *';
    const EVERY_30_M = '*/30 * * * *';
    const EVERY_1_H  = '0 * * * *';
    const EVERY_3_H  = '0 */3 * * *';
    const EVERY_6_H  = '0 */6 * * *';
    const EVERY_12_H = '0 */12 * * *';
    const EVERY_1_D  = '0 0 * * *';

    /**
     * @return array
     */
    public static function getOptionArray()
    {
        return [
            self::EVERY_10_M => __('Every 10 Minutes'),
            self::EVERY_30_M => __('Every 30 Minutes'),
            self::EVERY_1_H  => __('Every Hour'),
            self::EVERY_3_H  => __('Every 3 Hours'),
            self::EVERY_6_H  => __('Every 6 Hours'),
            self::EVERY_12_H => __('Every 12 Hours'),
            self::EVERY_1_D  => __('Everyday'),
        ];
    }
}
