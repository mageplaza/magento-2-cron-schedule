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

/**
 * Class Test
 * @package Mageplaza\CronSchedule\Model
 */
class Test
{
    public function sayA()
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/mp_test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('aaa ' . date('Y-m-d H:i:s'));
    }

    public function sayB()
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/mp_test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('bbb ' . date('Y-m-d H:i:s'));
    }

    public function say123()
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/mp_test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('123 ' . date('Y-m-d H:i:s'));
    }

    public function error()
    {
        //        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/mp_test.log');
        //        $logger = new \Zend\Log\Logger();
        //        $logger->addWriter($writer);
        $logger->info('123 ' . date('Y-m-d H:i:s'));
    }
}
