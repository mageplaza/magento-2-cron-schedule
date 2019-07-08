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

namespace Mageplaza\CronSchedule\Controller\Adminhtml\Job;

use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Mageplaza\CronSchedule\Controller\Adminhtml\AbstractJob;

/**
 * Class Edit
 * @package Mageplaza\CronSchedule\Controller\Adminhtml\Program
 */
class Edit extends AbstractJob
{
    /**
     * @return Page|ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $object = $this->_initJob();
        $name = $this->getRequest()->getParam('name');

        if ($name !== null) {
            if ($object->getData() === null) {
                $this->messageManager->addErrorMessage(__('This cron job no longer exists.'));

                return $this->_redirect('*/*/');
            }

            if (!$object->getIsUser()) {
                $this->messageManager->addErrorMessage(__('This cron job can not be edited.'));

                return $this->_redirect('*/*/');
            }
        }

        // restore form data
        if ($data = $this->_session->getMpCronScheduleData()) {
            $object->addData($data);
        }

        $this->registry->register('mpcronschedule_job', $object);

        $pageTitle = $name !== null ? __('Edit Cron Job "%1"', $name) : __('Create New Cron Job');
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend($pageTitle);

        return $resultPage;
    }
}
