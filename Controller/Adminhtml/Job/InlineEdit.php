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
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultInterface;
use Mageplaza\CronSchedule\Controller\Adminhtml\AbstractJob;

/**
 * Class InlineEdit
 * @package Mageplaza\CronSchedule\Controller\Adminhtml\Job
 */
class InlineEdit extends AbstractJob
{
    /**
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error      = false;
        $messages   = [];
        $items      = $this->getRequest()->getParam('items', []);

        if (empty($items) && !$this->getRequest()->getParam('isAjax')) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error'    => true,
            ]);
        }

        foreach (array_keys($items) as $name) {
            $object = $this->jobFactory->create()->setData($this->helper->getJobs($name));

            try {
                $object->changeJobStatus($items[$name]['status']);
            } catch (Exception $e) {
                $messages[] = '[Cron Job: ' . $object->getName() . '] ' . $e->getMessage();
                $error      = true;
            }
        }

        $this->cacheTypeList->cleanType('config');

        return $resultJson->setData(compact('messages', 'error'));
    }
}
