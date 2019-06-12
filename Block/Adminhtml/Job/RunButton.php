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

namespace Mageplaza\CronSchedule\Block\Adminhtml\Job;

use Magento\Backend\Block\Template;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class RunButton
 * @package Mageplaza\CronSchedule\Block\Adminhtml\Job
 */
class RunButton extends Template implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        $message = __('Are you sure you want to do this?');

        return [
            'id'       => 'apply',
            'label'    => __('Run All Cron Jobs'),
            'on_click' => "deleteConfirm('" . $message . "', '" . $this->getUrl('*/*/run') . "')",
            'class'    => 'secondary'
        ];
    }
}
