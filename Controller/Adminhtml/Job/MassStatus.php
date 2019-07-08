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
use Mageplaza\CronSchedule\Controller\Adminhtml\AbstractJob;

/**
 * Class MassStatus
 * @package Mageplaza\CronSchedule\Controller\Adminhtml\Job
 */
class MassStatus extends AbstractJob
{
    /**
     * @return ResponseInterface
     */
    public function execute()
    {
        $status = (int) $this->getRequest()->getParam('status');

        $data = $this->getRequest()->getParams();

        $count = 0;
        foreach ($this->getSelectedRecords($data) as $name) {
            try {
                $this->jobFactory->create()->setData($this->helper->getJobs($name))->changeJobStatus($status);
                $count++;
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        if ($count) {
            $this->cacheTypeList->cleanType('config');
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been updated.', $count));
        }

        return $this->_redirect('*/*/');
    }
}
