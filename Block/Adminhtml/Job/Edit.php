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

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;
use Mageplaza\CronSchedule\Model\Job;

/**
 * Class Edit
 * @package Mageplaza\CronSchedule\Block\Adminhtml\Job
 */
class Edit extends Container
{
    /**
     * @var string
     */
    protected $_objectId = 'name';

    /**
     * @var string
     */
    protected $_blockGroup = 'Mageplaza_CronSchedule';

    /**
     * @var string
     */
    protected $_controller = 'adminhtml_job';

    /**
     * Core registry
     *
     * @var Registry
     */
    public $_coreRegistry;

    /**
     * Edit constructor.
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;

        parent::__construct($context, $data);
    }

    /**
     * @return Job
     */
    protected function getJob()
    {
        return $this->_coreRegistry->registry('mpcronschedule_job');
    }

    /**
     * Construct
     */
    protected function _construct()
    {
        parent::_construct();

        $this->buttonList->add('save_and_continue', [
            'label'          => __('Save and Continue Edit'),
            'class'          => 'save',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form']]
            ]
        ]);

        $this->buttonList->add('save_and_execute', [
            'label'          => __('Save and Execute'),
            'class'          => 'save',
            'data_attribute' => [
                'mage-init' => [
                    'button' => [
                        'event'     => 'saveAndContinueEdit',
                        'target'    => '#edit_form',
                        'eventData' => ['action' => ['args' => ['is_execute' => '1']]]
                    ]
                ]
            ]
        ]);
    }

    /**
     * @return string
     */
    public function getHeaderText()
    {
        if ($name = $this->getJob()->getName()) {
            return __('Edit Cron Job "%1"', $name);
        }

        return __('New Cron Job');
    }

    /**
     * Return validation url for edit form
     *
     * @return string
     */
    public function getValidationUrl()
    {
        return $this->getUrl('mpcronschedule/*/validate', ['_current' => true]);
    }
}
