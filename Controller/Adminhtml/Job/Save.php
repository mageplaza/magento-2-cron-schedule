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
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Mageplaza\CronSchedule\Controller\Adminhtml\AbstractJob;

/**
 * Class Save
 * @package Mageplaza\CronSchedule\Controller\Adminhtml\Program
 */
class Save extends AbstractJob
{
    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        /** @var Http $request */
        $request = $this->getRequest();

        if ($data = $request->getPostValue()) {
            $object = $this->_initJob('org_name');
            $newObj = clone $object;

            $data['name'] = $request->getParam('code');

            try {
                $object->saveJob($newObj->addData($data));
                $this->cacheTypeList->cleanType('config');

                if ($request->getParam('is_execute')) {
                    $result = ['success' => 0, 'failure' => 0];

                    $this->executeJob($data, $result, true);

                    if ($result['success']) {
                        $this->messageManager->addSuccessMessage(__('The cron job has been saved and executed.'));
                    }
                } else {
                    $this->messageManager->addSuccessMessage(__('The cron job has been saved.'));
                }

                $this->_session->setMpCronScheduleData(false);

                if ($request->getParam('back', false)) {
                    return $this->_redirect('*/*/edit', ['name' => $data['name'], '_current' => true]);
                }
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->_session->setMpCronScheduleData($data);

                if ($name = $request->getParam('name')) {
                    return $this->_redirect('*/*/edit', ['name' => $name, '_current' => true]);
                }
            }
        }

        return $this->_redirect('*/*/');
    }
}
