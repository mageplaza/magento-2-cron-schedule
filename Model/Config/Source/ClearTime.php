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
 * Class ClearTime
 * @package Mageplaza\CronSchedule\Model\Config\Source
 */
class ClearTime extends AbstractSource
{
    const DISABLE   = '';
    const EVERY_1_D = '0 0 * * *';
    const EVERY_1_W = '0 0 * * 0';
    const EVERY_1_M = '0 0 1 * *';
    const EVERY_1_Y = '0 0 1 1 *';

    /**
     * @return array
     */
    public static function getOptionArray()
    {
        return [
            self::DISABLE   => __('Disable'),
            self::EVERY_1_D => __('Everyday'),
            self::EVERY_1_W => __('Weekly'),
            self::EVERY_1_M => __('Monthly'),
            self::EVERY_1_Y => __('Yearly'),
        ];
    }
}
