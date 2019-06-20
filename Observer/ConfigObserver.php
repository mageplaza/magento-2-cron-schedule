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

use Magento\Config\Model\ResourceModel\Config as ModelConfig;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Mageplaza\CronSchedule\Helper\Data;

/**
 * Class ConfigObserver
 * @package Mageplaza\CronSchedule\Observer
 */
class ConfigObserver implements ObserverInterface
{
    /**
     * @var ModelConfig
     */
    private $modelConfig;

    /**
     * @var Data
     */
    private $helper;

    /**
     * ConfigObserver constructor.
     *
     * @param ModelConfig $modelConfig
     * @param Data $helper
     */
    public function __construct(
        ModelConfig $modelConfig,
        Data $helper
    ) {
        $this->modelConfig = $modelConfig;
        $this->helper      = $helper;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if ($day = $this->helper->getClearSchedule()) {
            $expr = sprintf('0 */%s * * *', $day * 24);
        } else {
            $expr = '';
        }

        $this->modelConfig->saveConfig(
            Data::CONFIG_MODULE_PATH . '/general/clear_schedule_expr',
            $expr
        );
    }
}
