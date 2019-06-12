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

namespace Mageplaza\CronSchedule\Block\Adminhtml\Job\Edit;

use Exception;

/**
 * Class Tabs
 * @package Mageplaza\CronSchedule\Block\Adminhtml\Job\Edit
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        parent::_construct();

        $this->setId('job_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Cron Job Information'));
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    protected function _beforeToHtml()
    {
        $this->addTab('main', [
            'label'   => __('General'),
            'title'   => __('General'),
            'content' => $this->getChildHtml('main'),
            'active'  => true
        ]);

        return parent::_beforeToHtml();
    }
}
