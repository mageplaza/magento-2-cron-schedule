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

use Exception;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Mageplaza\CronSchedule\Controller\Adminhtml\AbstractJob;

/**
 * Class Delete
 * @package Mageplaza\CronSchedule\Controller\Adminhtml\Program
 */
class Delete extends AbstractJob
{
    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        if ($name = $this->getRequest()->getParam('name')) {
            $object = $this->_initJob();

            if ($object->getIsUser()) {
                try {
                    $object->deleteJob();
                    $this->messageManager->addSuccessMessage(__('The cron job has been deleted.'));
                } catch (Exception $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                }
            } else {
                $this->messageManager->addErrorMessage(__('The cron job can\'t be deleted.'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('We can\'t find a cron job to delete.'));
        }

        return $this->_redirect('*/*/');
    }
}
