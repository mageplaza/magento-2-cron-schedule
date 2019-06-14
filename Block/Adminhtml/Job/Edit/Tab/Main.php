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

namespace Mageplaza\CronSchedule\Block\Adminhtml\Job\Edit\Tab;

use Exception;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\Form;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Mageplaza\CronSchedule\Model\Config\Source\Group;
use Mageplaza\CronSchedule\Model\Config\Source\JobStatus;
use Mageplaza\CronSchedule\Model\EmailNotify;
use Mageplaza\CronSchedule\Model\Job;

/**
 * Class Main
 * @package Mageplaza\CronSchedule\Block\Adminhtml\Job\Edit\Tab
 */
class Main extends Generic
{
    /**
     * @var mixed
     */
    protected $_job;

    /**
     * @var JobStatus
     */
    private $jobStatus;

    /**
     * @var Group
     */
    private $group;

    /**
     * Main constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param JobStatus $jobStatus
     * @param Group $group
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        JobStatus $jobStatus,
        Group $group,
        array $data = []
    ) {
        $this->jobStatus = $jobStatus;
        $this->group     = $group;

        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @inheritdoc
     * @throws LocalizedException
     */
    protected function _prepareForm()
    {
        /** @var Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $fieldset = $form->addFieldset('main_fieldset', ['legend' => __('General')]);

        $name = $this->getJobObject()->getName();

        $fieldset->addField('code', 'text', [
            'name'     => 'code',
            'label'    => __('Cron Job Code'),
            'title'    => __('Cron Job Code'),
            'class'    => 'validate-code',
            'value'    => $name,
            'required' => true
        ]);

        $fieldset->addField('group', 'select', [
            'name'   => 'group',
            'label'  => __('Group Name'),
            'title'  => __('Group Name'),
            'values' => $this->group->toOptionArray()
        ]);

        $fieldset->addField('status', 'select', [
            'name'   => 'status',
            'label'  => __('Status'),
            'title'  => __('Status'),
            'values' => $this->jobStatus->toOptionArray()
        ]);

        $fieldset->addField('instance', 'text', [
            'name'     => 'instance',
            'label'    => __('Instance Classpath'),
            'title'    => __('Instance Classpath'),
            'note'     => __('E.g: ' . EmailNotify::class),
            'required' => true
        ]);

        $fieldset->addField('method', 'text', [
            'name'     => 'method',
            'label'    => __('Job Method'),
            'title'    => __('Job Method'),
            'note'     => __('E.g: sendEmail'),
            'required' => true
        ]);

        $note = 'Using Cron format <a href="%1" target="_blank">here</a> to setting time for running cron job.';
        $fieldset->addField('schedule', 'text', [
            'name'     => 'schedule',
            'label'    => __('Time Schedule'),
            'title'    => __('Time Schedule'),
            'note'     => __($note, 'http://www.nncron.ru/help/EN/working/cron-format.htm'),
            'required' => true
        ]);

        if ($name) {
            $fieldset->addField('org_name', 'hidden', ['name' => 'org_name', 'value' => $name]);
        } else {
            $fieldset->addField('is_user', 'hidden', ['name' => 'is_user', 'value' => 1]);
        }

        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    protected function _initFormValues()
    {
        $object = $this->getJobObject();

        if ($object->getData('status') === null) {
            $object->setData('status', 1);
        }

        $this->getForm()->addValues($object->getData());

        return parent::_initFormValues();
    }

    /**
     * @return Job
     */
    protected function getJobObject()
    {
        if ($this->_job === null) {
            return $this->_coreRegistry->registry('mpcronschedule_job');
        }

        return $this->_job;
    }
}
